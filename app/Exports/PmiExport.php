<?php

namespace App\Exports;

use App\Models\Pmi;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PmiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private int $pmiId;
    private Collection $rows;

    public function __construct(int $pmiId)
    {
        $this->pmiId = $pmiId;
        $this->rows  = $this->buildRows();
    }

    private function buildRows(): Collection
    {
        $pmi = Pmi::with(
            'factoresCriticos.calificacion.grupo.padre',
            'factoresCriticos.objetivos.metas.actividades',
            'factoresCriticos.objetivos.metas.indicadorInfo'
        )->findOrFail($this->pmiId);

        $rows = collect();

        foreach ($pmi->factoresCriticos as $fc) {
            $gestion    = $fc->calificacion->grupo->padre->nombre ?? "Sin gestión";
            $componente = $fc->calificacion->nombre ?? "Sin componente";

            $objetivos = $fc->objetivos->count() ? $fc->objetivos : collect([null]);
            foreach ($objetivos as $obj) {
                $metas = $obj?->metas->count() ? $obj->metas : collect([null]);

                foreach ($metas as $meta) {
                    $actividades = $meta?->actividades->count() ? $meta->actividades : collect([null]);

                    foreach ($actividades as $actividad) {
                        $rows->push([
                            'gestion'      => $gestion,
                            'componente'   => $componente,
                            'factor'       => $fc,
                            'objetivo'     => $obj,
                            'meta'         => $meta,
                            'actividad'    => $actividad,
                        ]);
                    }
                }
            }
        }

        return $rows->values();
    }

    public function collection(): Collection
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Gestión',
            'Componente',
            'Factor Crítico',
            'Objetivo',
            'Meta',
            'Indicador',
            'Actividad',
            'Recurso ($)',
            'Responsables',
            '% Completitud',
        ];
    }

    public function map($row): array
    {
        $meta        = $row['meta'];
        $actividad   = $row['actividad'];

        $completitudMeta = $this->calcularCompletitudMeta($meta);

        $indicador = "Sin indicador";
        if ($meta && $meta->indicadorInfo) {
            $indicador = $meta->indicadorInfo->unidad_parcial . " " .
                ($meta->indicador ?? '') . " / " .
                $meta->indicadorInfo->unidad_total . " " .
                ($meta->valor_requerido ?? '');
        }

        return [
            $row['gestion'],
            $row['componente'],
            $row['factor']?->descripcion ?? "Sin descripción",
            $row['objetivo']?->descripcion ?? "Sin descripción",
            $meta?->descripcion ?? "Sin descripción",
            $indicador, // <- aquí va ya construido
            $actividad?->descripcion ?? "Sin actividades",
            $actividad?->recursos ?? "Sin recursos",
            $actividad?->responsables ?? "Sin asignar",
            $actividad?->accumulated
                ? $actividad->accumulated . "% (" . $actividad->slug_estado . ")"
                : ($meta ? $completitudMeta . "% (Meta)" : "Sin completitud"),
        ];
    }

    private function calcularCompletitudMeta($meta): float
    {
        if (!$meta?->actividades?->count()) {
            return 0;
        }

        return round(
            $meta->actividades->reduce(function ($total, $act) {
                $peso     = $act->peso ?? 0;
                $avance   = $act->accumulated ?? 0;
                return $total + ($peso * $avance) / 100;
            }, 0),
            2
        );
    }

    public function styles(Worksheet $sheet): array
    {
        $columns     = range('A', 'J');
        $columnWidth = 25;

        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidth);
            $sheet->getColumnDimension($column)->setAutoSize(false);
        }

        $highestColumn = $sheet->getHighestColumn();
        $highestRow    = $sheet->getHighestRow();

        // Ajustes generales
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getAlignment()->setWrapText(true);
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        // Bordes
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Encabezado
        $sheet->getStyle("A1:J1")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFCCE5FF'],
            ],
        ]);

        // --- Fusionar celdas (rowSpan) ---
        $startRow = 2;
        $rows     = $this->rows;
        $rowCount = $rows->count();

        foreach (['gestion' => 'A', 'componente' => 'B', 'factor' => 'C', 'objetivo' => 'D', 'meta' => 'E', 'indicador' => 'F'] as $key => $col) {
            $currentValue = null;
            $mergeStart   = $startRow;

            for ($i = 0; $i < $rowCount; $i++) {
                $excelRow = $startRow + $i;
                $value    = $this->getRowValue($rows[$i], $key);

                if ($value !== $currentValue) {
                    if ($mergeStart < $excelRow - 1) {
                        $sheet->mergeCells("{$col}{$mergeStart}:{$col}" . ($excelRow - 1));
                        $sheet->getStyle("{$col}{$mergeStart}:{$col}" . ($excelRow - 1))
                            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    }
                    $mergeStart   = $excelRow;
                    $currentValue = $value;
                }
            }

            // Cerrar el último bloque
            if ($mergeStart < $startRow + $rowCount - 1) {
                $sheet->mergeCells("{$col}{$mergeStart}:{$col}" . ($startRow + $rowCount - 1));
                $sheet->getStyle("{$col}{$mergeStart}:{$col}" . ($startRow + $rowCount - 1))
                    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }
        }

        return [];
    }

    private function getRowValue($row, $key)
    {
        return match ($key) {
            'gestion'   => $row['gestion'],
            'componente'=> $row['componente'],
            'factor'    => $row['factor']?->descripcion ?? "Sin descripción",
            'objetivo'  => $row['objetivo']?->descripcion ?? "Sin descripción",
            'meta'      => $row['meta']?->descripcion ?? "Sin descripción",
            default     => null,
        };
    }
}
