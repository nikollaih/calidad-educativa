<?php

namespace App\Exports;

use App\Models\Pmi;
use App\Models\PmiMetaVinculada;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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

class PmiCumplimientoExport implements FromCollection, WithTitle, WithHeadings, WithStyles, WithColumnWidths, WithEvents {
    private int $pmiId;
    private string $municipio;
    private string $institucion;
    private Collection $rows;
    private array $dataRows = [];

    public function __construct(int $pmiId) {
        $this->pmiId = $pmiId;
        $this->rows  = $this->buildRows();
        $this->buildDataStructure();
    }
    /**
     * Construir filas con la nueva estructura: Meta → Indicadores → Actividades
     */
    private function buildRows(): Collection {
        $pmi = Pmi::with(
            'institucion.municipio',
        )->findOrFail($this->pmiId);
        $this->municipio = $pmi?->institucion?->municipio?->nombre;
        $this->institucion = $pmi?->institucion?->nombre;

        $metas = PmiMetaVinculada::whereHas('objetivo.factor', function ($query) {
            $query->where('pmi_id', $this->pmiId);
        })
            ->with('indicadores.actividades')
            ->get();

        Log::info(json_encode($metas));
        return $metas;
    }

    /**
     * Construir la estructura de datos completa
     */
    private function buildDataStructure() {
        $currentRow = 14; // Inicia después de los encabezados (fila 14)

        foreach ($this->rows as $meta) {
            if ($meta->indicadores->isEmpty()) {
                // Meta sin indicadores
                $this->dataRows[] = [
                    'row' => $currentRow,
                    'meta' => $meta->descripcion,
                    'meta_range' => "B{$currentRow}:B{$currentRow}",
                    'instrumentos' => '',
                    'responsables' => '',
                    'frecuencia' => '',
                    'fecha_inicio' => '',
                    'fecha_fin' => '',
                    'accumulated' => null,
                    'slug_estado' => '',
                ];
                $currentRow++;
            } else {
                $metaRowStart = $currentRow;

                foreach ($meta->indicadores as $indicador) {
                    if ($indicador->actividades->isEmpty()) {
                        // Indicador sin actividades
                        $this->dataRows[] = [
                            'row' => $currentRow,
                            'meta' => null,
                            'meta_range' => null,
                            'fecha_inicio' => '',
                            'fecha_fin' => '',
                            'accumulated' => null,
                            'slug_estado' => '',
                        ];
                        $currentRow++;
                    } else {
                        $indicadorRowStart = $currentRow;

                        foreach ($indicador->actividades as $actividad) {
                            $descripcion = $actividad->descripcion ?? '';
                            $fechaInicio = $actividad->fecha_inicio ?? '';
                            $fechaFin = $actividad->fecha_fin ?? '';
                            $accumulated = $actividad->accumulated ?? 0;
                            $slugEstado = $actividad->slug_estado ?? '';

                            $this->dataRows[] = [
                                'row' => $currentRow,
                                'meta' => null,
                                'meta_range' => null,
                                'descripcion' => $descripcion,
                                'fecha_inicio' => $fechaInicio,
                                'fecha_fin' => $fechaFin,
                                'accumulated' => $accumulated,
                                'slug_estado' => $slugEstado,
                            ];
                            $currentRow++;
                        }
                    }
                }

                // Marcar el rango de la meta
                $metaRowEnd = $currentRow - 1;
                if ($metaRowEnd >= $metaRowStart) {
                    $this->dataRows[$metaRowStart - 14]['meta'] = $meta->descripcion;
                    $this->dataRows[$metaRowStart - 14]['meta_range'] = "B{$metaRowStart}:B{$metaRowEnd}";
                }
            }
        }
    }


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
            ['', 'MUNICIPIO: ', $this->municipio, '', '', '', '', '', '', '', '', ''], // Fila 6
            ['', 'INSTITUCIÓN EDUCATIVA: ', $this->institucion, '', '', '', '', '', '', '', '', ''], // Fila 7
            ['', 'AÑO:',date("Y") , '', '', '', '', '', '', '', '', ''], // Fila 8
            [''], // Fila 9
            ['', 'FECHA DE SEGUIMIENTO:    DÍA '. date('d') .'   MES '. date('m')  .'  AÑO ' . date('Y'), '', '', '', '', '', '', '', '', '', ''], // Fila 10
            [''], // Fila 11
            ['', 'METAS', 'ACTIVIDADES', 'PLAZO', '', 'ESTADO DE EJECUCIÓN', '', '', '', '', '', 'Observaciones'], // Fila 12
            ['', '', '', 'INICIAL', 'FINAL', 'INI', 'ESP', 'CANC', 'FIN', 'EJ', '% EJ', ''] // Fila 13
        ];
    }

    public function columnWidths(): array {
        return [
            'A' => 1.42,
            'B' => 39.28,
            'C' => 51.71,
            'D' => 15.99,
            'E' => 15.99,
            'F' => 10.13,
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
            'B10' => [
                'font' => ['name' => 'Calibri', 'size' => 14, 'bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER]
            ],
            'B12:L13' => [
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
                $sheet->mergeCells('K2:L4');
                $sheet->mergeCells('C3:J4');
                $sheet->mergeCells('B12:B13');
                $sheet->mergeCells('C12:C13');
                $sheet->mergeCells('C2:J2');
                $sheet->mergeCells('B10:L10');
                $sheet->mergeCells('B2:B4');
                $sheet->mergeCells('F12:K12');
                $sheet->mergeCells('C5:I5');
                $sheet->mergeCells('D12:E12');
                $sheet->mergeCells('L12:L13');

                // Alturas de fila
                $rowHeights = [
                    1 => 15.75, 2 => 41.25, 3 => 21.0, 4 => 21.0, 5 => 4.15,
                    6 => 26.25, 7 => 26.25, 8 => 26.25, 9 => 10.15, 10 => 18.75,
                    11 => 5.45, 12 => 24.75, 13 => 33.0
                ];

                foreach ($rowHeights as $row => $height) {
                    $sheet->getRowDimension($row)->setRowHeight($height);
                }

                // Llenar las filas de datos
                $currentRow = 14;
                foreach ($this->dataRows as $dataRow) {
                    // Meta (columna B)
                    if (isset($dataRow['meta']) && $dataRow['meta']) {
                        $sheet->setCellValue("B{$currentRow}", $dataRow['meta']);
                    }

                    // Indicador (columna C)
                    if (isset($dataRow['descripcion']) && $dataRow['descripcion']) {
                        $sheet->setCellValue("C{$currentRow}", $dataRow['descripcion']);
                    }

                    // Plazo Inicial (columna D)
                    if (isset($dataRow['fecha_inicio']) && $dataRow['fecha_inicio']) {
                        $sheet->setCellValue("D{$currentRow}", $dataRow['fecha_inicio']);
                    }

                    // Plazo Final (columna E)
                    if (isset($dataRow['fecha_fin']) && $dataRow['fecha_fin']) {
                        $sheet->setCellValue("E{$currentRow}", $dataRow['fecha_fin']);
                    }

                    // Estado de ejecución (columnas F, G, H, I, J, K)
                    $accumulated = $dataRow['accumulated'] ?? null;
                    if ($accumulated !== null) {
                        if ($accumulated == 0) {
                            $sheet->setCellValue("F{$currentRow}", "X"); // INI
                        } elseif ($accumulated < 100) {
                            $sheet->setCellValue("J{$currentRow}", "X"); // EJ
                        } elseif ($accumulated == 100) {
                            $sheet->setCellValue("I{$currentRow}", "X"); // FIN
                        }

                        // % EJ (columna K)
                        $sheet->setCellValue("K{$currentRow}", $accumulated . "%");
                    }

                    // Observaciones (columna L)
                    if (isset($dataRow['slug_estado']) && $dataRow['slug_estado']) {
                        $sheet->setCellValue("L{$currentRow}", $dataRow['slug_estado']);
                    }

                    $currentRow++;
                }

                // Ajustar altura de las filas de datos
                $totalRows = 13 + count($this->dataRows);
                for ($i = 14; $i <= $totalRows; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(18.0);
                }

                // Ajuste de texto en todas las celdas
                $sheet->getStyle("A1:L{$totalRows}")->getAlignment()->setWrapText(true);

                // Fusionar celdas para metas e indicadores
                foreach ($this->dataRows as $dataRow) {
                    if (isset($dataRow['meta_range']) && $dataRow['meta_range']) {
                        $sheet->mergeCells($dataRow['meta_range']);
                        // Centrar verticalmente las metas
                        $sheet->getStyle($dataRow['meta_range'])->getAlignment()
                            ->setVertical(Alignment::VERTICAL_CENTER);
                    }

                    if (isset($dataRow['indicador_range']) && $dataRow['indicador_range']) {
                        $sheet->mergeCells($dataRow['indicador_range']);
                        // Centrar verticalmente los indicadores
                        $sheet->getStyle($dataRow['indicador_range'])->getAlignment()
                            ->setVertical(Alignment::VERTICAL_CENTER);
                    }
                }

                // Aplicar bordes a las filas de datos
                $lastDataRow = 13 + count($this->dataRows);
                $sheet->getStyle("B14:L{$lastDataRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Borde exterior MEDIUM para toda la tabla de datos
                $sheet->getStyle("B12:L{$lastDataRow}")->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                // Centrar el contenido de las columnas de estado de ejecución
                $sheet->getStyle("D14:K{$lastDataRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Bordes según especificaciones
                // Bordes MEDIUM para los rectángulos principales
                $sheet->getStyle('B2:B4')->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                $sheet->getStyle('C2:J4')->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                $sheet->getStyle('K2:L4')->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                $sheet->getStyle('B5:L11')->applyFromArray([
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
                $sheet->getStyle('B12:L13')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Agregar imagen en K2:L4
                $imagePath = public_path('imagenes/educacion_menu.png');
                if (file_exists($imagePath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo');
                    $drawing->setPath($imagePath);
                    $drawing->setCoordinates('K2');

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
