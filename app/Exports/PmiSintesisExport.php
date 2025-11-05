<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PmiSintesisExport implements FromCollection, WithTitle, WithHeadings, WithStyles, WithColumnWidths, WithEvents {
    public function collection() {
        return new Collection([]);
    }

    public function title(): string {
        return 'Cumplimiento objetivos PMI';
    }

    public function headings(): array {
        return [
            [''], // Fila 1 vacía
            ['', '', 'SECRETARÍA DE EDUCACIÓN DEPARTAMENTAL DEL QUINDÍO' . "\n" . 'DIRECCION  CALIDAD EDUCATIVA', '', '', '', '', '', '', '', '', ''], // Fila 2
            ['', '', 'REVISIÓN  DEL CUMPLIMIENTO DE OBJETIVOS Y METAS' . "\n" . 'DEL PLAN DE MEJORAMIENTO INSTITUCIONAL', '', '', '', '', '', '', '', '', ''], // Fila 3
            [''], // Fila 4
            [''], // Fila 5
            ['', 'MUNICIPIO: ', '', '', '', '', '', '', '', '', '', ''], // Fila 6
            ['', 'INSTITUCIÓN EDUCATIVA: ', '', '', '', '', '', '', '', '', '', ''], // Fila 7
            ['', 'AÑO:', '2025', '', '', '', '', '', '', '', '', ''], // Fila 8
            [''], // Fila 9
            ['', 'META', 'INDICADORES', 'INSTRUMENTOS DE RECOLECCIÓN', 'RESPONSABLES', 'FRECUENCIA DE RECOLECCIÓN', '', '', '', '', '', ''], // Fila 10
            ['', '', '', '', '', '', '', '', '', '', '', ''] // Fila 11
        ];
    }

    public function columnWidths(): array {
        return [
            'A' => 1.42,
            'B' => 39.28,
            'C' => 51.71,
            'D' => 51.71,
            'E' => 51.71,
            'F' => 39.28,
            'G' => 10.13,
            'H' => 10.13,
            'I' => 10.13,
            'J' => 10.13,
            'K' => 10.13,
            'L' => 35.28,
        ];
    }

    public function styles(Worksheet $sheet) {
        return [
            'C2' => [
                'font' => ['name' => 'Arial', 'size' => 14, 'bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_BOTTOM]
            ],
            'C3' => [
                'font' => ['name' => 'Arial', 'size' => 14, 'bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
            ],
            'B6:B8' => [
                'font' => ['name' => 'Calibri', 'size' => 14, 'bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_GENERAL, 'vertical' => Alignment::VERTICAL_BOTTOM]
            ],
            'C6' => [
                'font' => ['name' => 'Calibri', 'size' => 11, 'bold' => false],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_GENERAL, 'vertical' => Alignment::VERTICAL_BOTTOM]
            ],
            'C7' => [
                'font' => ['name' => 'Calibri', 'size' => 11, 'bold' => false],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_GENERAL, 'vertical' => Alignment::VERTICAL_BOTTOM]
            ],
            'C8' => [
                'font' => ['name' => 'Calibri', 'size' => 11, 'bold' => false],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_GENERAL, 'vertical' => Alignment::VERTICAL_BOTTOM]
            ],
            'B10:F10' => [
                'font' => ['name' => 'Calibri', 'size' => 12, 'bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFC0C0C0']]
            ],
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Fusiones de celdas
                $sheet->mergeCells('F2:F4');
                $sheet->mergeCells('C3:E4');
                $sheet->mergeCells('C2:E2');
                $sheet->mergeCells('B2:B4');
                $sheet->mergeCells('C5:F5');

                // Alturas de fila
                $rowHeights = [
                    1 => 15.75, 2 => 41.25, 3 => 21.0, 4 => 21.0, 5 => 4.15,
                    6 => 26.25, 7 => 26.25, 8 => 26.25, 9 => 10.15, 10 => 41.25,
                    11 => 24.75, 12 => 33.0
                ];

                foreach ($rowHeights as $row => $height) {
                    $sheet->getRowDimension($row)->setRowHeight($height);
                }

                // Filas de datos (13 en adelante)
                for ($i = 13; $i <= 32; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(18.0);
                }

                // Ajuste de texto en todas las celdas
                $sheet->getStyle('A1:F12')->getAlignment()->setWrapText(true);

                // Bordes según especificaciones
                // Bordes MEDIUM para los rectángulos principales
                $sheet->getStyle('B2:B4')->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                $sheet->getStyle('C2:F4')->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                $sheet->getStyle('F2:F4')->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                $sheet->getStyle('B5:F10')->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                // C6, C7, C8: thin borders internos
                $sheet->getStyle('C6')->applyFromArray([
                    'borders' => [
                        'bottom' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
                $sheet->getStyle('C7')->applyFromArray([
                    'borders' => [
                        'bottom' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
                $sheet->getStyle('C8')->applyFromArray([
                    'borders' => [
                        'bottom' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
                // Bordes para encabezados de tabla (interno thin)
                $sheet->getStyle('B10:F10')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Borde exterior MEDIUM para la tabla de encabezados
                $sheet->getStyle('B10:F10')->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);
                // Agregar imagen en K2:L4
                $imagePath = public_path('imagenes/educacion_menu.png');
                if (file_exists($imagePath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo');
                    $drawing->setPath($imagePath);
                    $drawing->setCoordinates('F2');

                    // Sin offsets para que ocupe todo el espacio
                    $drawing->setOffsetX(0);
                    $drawing->setOffsetY(0);

                    // Calcular el tamaño de la celda combinada K2:L4
                    // Altura: fila 2 (41.25) + fila 3 (21.0) + fila 4 (21.0) = 83.25 puntos
                    // Convertir puntos a píxeles (1 punto = 1.33 píxeles aprox)
                    $heightInPixels = 83.25 * 1.33;

                    // Establecer altura para llenar la celda
                    $drawing->setHeight((int)$heightInPixels);

                    // Opcionalmente, si quieres controlar también el ancho:
                    // Ancho de K + L = aproximadamente 45.41 puntos
                    // $widthInPixels = 45.41 * 7; // 1 unidad de ancho Excel ≈ 7 píxeles
                    // $drawing->setWidth((int)$widthInPixels);

                    $drawing->setWorksheet($sheet->getDelegate());
                }
            },
        ];
    }
}
