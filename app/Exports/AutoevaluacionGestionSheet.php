<?php

namespace App\Exports;

use App\Models\GrupoCalificacion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AutoevaluacionGestionSheet implements FromArray, WithColumnWidths, WithEvents, WithTitle {
    private array $rows = [];
    private array $componentRows = [];

    public function __construct(
        ?GrupoCalificacion $grupo,
        Collection $notasSeleccionadas,
        private string $nombreHoja,
        int|string|null $anioVigencia,
        string $institucion,
    ) {
        $this->rows = [
            ["AUTOEVALUACIÓN - GESTIÓN {$nombreHoja}", '', '', '', '', ''],
            ['Institución', $institucion, '', 'Año de vigencia', $anioVigencia ?? '', ''],
            ['', '', '', '', '', ''],
            ['Código', 'Componente / Ítem', 'Calificación', 'Categoría', 'Descriptor', 'Evidencia'],
        ];

        if (!$grupo) {
            return;
        }

        $componentes = $grupo->hijos->sortBy('indice', SORT_NATURAL);

        foreach ($componentes as $componente) {
            $items = $componente->calificaciones->sortBy('indice', SORT_NATURAL);
            $total = 0;

            foreach ($items as $item) {
                $nota = $notasSeleccionadas->get($item->indice);
                $total += $nota?->valor ?? 0;
            }

            $promedio = $items->isEmpty() ? 'N/A' : number_format($total / $items->count(), 2, '.', '');
            $this->rows[] = [
                $componente->indice,
                $componente->nombre,
                "Promedio: {$promedio}",
                '',
                '',
                '',
            ];
            $this->componentRows[] = count($this->rows);

            foreach ($items as $item) {
                $nota = $notasSeleccionadas->get($item->indice);
                $valor = $nota ? (int) $nota->valor : null;

                $this->rows[] = [
                    $item->indice,
                    $item->nombre,
                    $valor ?? 'N/A',
                    $this->categoria($valor),
                    $nota?->descripcion ?? '',
                    $nota?->pivot?->evidencia ?? '',
                ];
            }
        }
    }

    public function array(): array {
        return $this->rows;
    }

    public function title(): string {
        return $this->nombreHoja;
    }

    public function columnWidths(): array {
        return [
            'A' => 12,
            'B' => 46,
            'C' => 16,
            'D' => 19,
            'E' => 58,
            'F' => 48,
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('B2:C2');
                $sheet->mergeCells('E2:F2');

                $sheet->getStyle("A1:F{$lastRow}")->applyFromArray([
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_TOP,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 15, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF164E75'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(30);

                $sheet->getStyle('A2:F2')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEAF2F8'],
                    ],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle('A2')->getFont()->setBold(true);
                $sheet->getStyle('D2')->getFont()->setBold(true);
                $sheet->getRowDimension(2)->setRowHeight(24);

                $sheet->getStyle('A4:F4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF2F75A5'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
                $sheet->getRowDimension(4)->setRowHeight(30);

                foreach ($this->componentRows as $row) {
                    $sheet->mergeCells("C{$row}:F{$row}");
                    $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['argb' => 'FF164E75']],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFDCEAF4'],
                        ],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                    $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getRowDimension($row)->setRowHeight(25);
                }

                $sheet->freezePane('A5');
            },
        ];
    }

    private function categoria(?int $valor): string {
        return match ($valor) {
            1 => 'Existencia',
            2 => 'Pertinencia',
            3 => 'Apropiación',
            4 => 'Mejoramiento',
            default => '',
        };
    }
}
