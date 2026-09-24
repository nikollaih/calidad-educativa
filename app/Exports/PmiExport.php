<?php

namespace App\Exports;

use App\Models\Pmi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PmiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize {
    private int $pmiId;
    private Collection $rows;

    public function __construct(int $pmiId) {
        $this->pmiId = $pmiId;
        $this->rows  = $this->buildRows();
    }

    /**
     * Construir filas con la nueva estructura: Meta → Indicadores → Actividades
     */
    private function buildRows(): Collection {
        $pmi = Pmi::with(
            'factoresCriticos.calificacion.grupo.padre',
            'factoresCriticos.objetivos.metas.indicadores.actividades'
        )->findOrFail($this->pmiId);

        $rows = collect();
        $uniqueCounter = 0; // Contador para generar IDs únicos

        foreach ($pmi->factoresCriticos as $fc) {
            $gestion    = $fc->calificacion->grupo->padre->nombre ?? "Sin gestión";
            $componente = $fc->calificacion->nombre ?? "Sin componente";

            $objetivos = $fc->objetivos->count() ? $fc->objetivos : collect([null]);

            foreach ($objetivos as $obj) {
                $metas = $obj?->metas->count() ? $obj->metas : collect([null]);

                foreach ($metas as $meta) {
                    // Ahora iteramos sobre los indicadores de la meta
                    $indicadores = $meta?->indicadores->count() ? $meta->indicadores : collect([null]);

                    foreach ($indicadores as $indicador) {
                        // Cada indicador tiene sus propias actividades
                        $actividades = $indicador?->actividades->count()
                            ? $indicador->actividades
                            : collect([null]);

                        foreach ($actividades as $actividad) {
                            $rows->push([
                                'gestion'    => $gestion,
                                'componente' => $componente,
                                'factor'     => $fc,
                                'objetivo'   => $obj,
                                'meta'       => $meta,
                                'indicador'  => $indicador,
                                'actividad'  => $actividad,
                                // IDs únicos para cada fila sin datos
                                'unique_objetivo_id'  => $obj ? null : ++$uniqueCounter,
                                'unique_meta_id'      => $meta ? null : ++$uniqueCounter,
                                'unique_indicador_id' => $indicador ? null : ++$uniqueCounter,
                            ]);
                        }
                    }
                }
            }
        }

        return $rows->values();
    }

    public function collection(): Collection {
        return $this->rows;
    }

    public function headings(): array {
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
            '% Avance Actividad',
        ];
    }

    public function map($row): array {
        $meta      = $row['meta'];
        $indicador = $row['indicador'];
        $actividad = $row['actividad'];

        // Calcular completitud del indicador y de la meta
        $completitudIndicador = $this->calcularCompletitudIndicador($indicador);
        $completitudMeta      = $this->calcularCompletitudMeta($meta);

        // Construir texto del indicador (fórmula)
        $indicadorTexto = "Sin indicador";
        if ($indicador) {
            $indicadorTexto = ($indicador->unidad_parcial ?? 'N/A') . " / " .
                            ($indicador->unidad_total ?? 'N/A');
        }

        return [
            $row['gestion'],
            $row['componente'],
            $row['factor']?->descripcion ?? "Sin descripción",
            $row['objetivo']?->descripcion ?? "Sin descripción",
            $meta?->descripcion ?? "Sin descripción",
            $indicadorTexto,
            $actividad?->descripcion ?? "Sin actividades",
            $actividad?->recursos ?? "Sin recursos",
            $actividad?->responsables ?? "Sin asignar",
            $actividad?->accumulated !== null
                ? $actividad->accumulated . "% (" . ($actividad->slug_estado ?? 'N/A') . ")"
                : "Sin avance",
        ];
    }

    /**
     * Calcular completitud de un indicador basado en sus actividades
     */
    private function calcularCompletitudIndicador($indicador): float {
        if (!$indicador?->actividades?->count()) {
            return 0;
        }

        return round(
            $indicador->actividades->reduce(function ($total, $act) {
                $peso   = $act->peso ?? 0;
                $avance = $act->accumulated ?? 0;
                return $total + ($peso * $avance) / 100;
            }, 0),
            2
        );
    }

    /**
     * Calcular completitud de una meta (promedio de sus indicadores)
     */
    private function calcularCompletitudMeta($meta): float {
        if (!$meta?->indicadores?->count()) {
            return 0;
        }

        $totalAvance = $meta->indicadores->reduce(function ($sum, $ind) {
            return $sum + $this->calcularCompletitudIndicador($ind);
        }, 0);

        return round($totalAvance / $meta->indicadores->count(), 2);
    }

    public function styles(Worksheet $sheet): array {
        $columns     = range('A', 'J'); // Solo 10 columnas (A-J)
        $columnWidth = 25;

        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidth);
            $sheet->getColumnDimension($column)->setAutoSize(false);
        }

        $highestColumn = 'J'; // Última columna con datos
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

        // --- Fusionar celdas (rowSpan) para niveles jerárquicos ---
        $startRow = 2;
        $rows     = $this->rows;
        $rowCount = $rows->count();

        // Columnas que necesitan merge: gestión, componente, factor, objetivo, meta, indicador
        $mergeColumns = [
            'gestion'    => 'A',
            'componente' => 'B',
            'factor'     => 'C',
            'objetivo'   => 'D',
            'meta'       => 'E',
            'indicador'  => 'F',
        ];

        foreach ($mergeColumns as $key => $col) {
            $currentValue = null;
            $mergeStart   = $startRow;

            for ($i = 0; $i < $rowCount; $i++) {
                $excelRow = $startRow + $i;
                $value    = $this->getRowValue($rows[$i], $key);

                if ($value !== $currentValue) {
                    // Fusionar bloque anterior si tiene más de 1 fila
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
            if ($mergeStart <= $startRow + $rowCount - 1) {
                $endRow = $startRow + $rowCount - 1;
                if ($mergeStart < $endRow) {
                    $sheet->mergeCells("{$col}{$mergeStart}:{$col}{$endRow}");
                    $sheet->getStyle("{$col}{$mergeStart}:{$col}{$endRow}")
                        ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                }
            }
        }

        return [];
    }

    /**
     * Obtener valor único de fila para comparación en merge
     */
    private function getRowValue($row, $key) {
        return match ($key) {
            'gestion'    => $row['gestion'],
            'componente' => $row['componente'],
            'factor'     => $row['factor']?->id ?? null,
            'objetivo'   => $row['objetivo']?->id ?? $row['unique_objetivo_id'] ?? null,
            'meta'       => $row['meta']?->id ?? $row['unique_meta_id'] ?? null,
            'indicador'  => $row['indicador']?->id ?? $row['unique_indicador_id'] ?? null,
            default      => null,
        };
    }
}
