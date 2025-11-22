<?php

namespace App\Exports;

use App\Models\Pmi;
use App\Models\PmiObjetivoVinculado;
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

class PmiEvaluacionExport implements FromCollection, WithTitle, WithHeadings, WithStyles, WithColumnWidths, WithEvents {
    private int $pmiId;
    private Pmi $pmi;
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
     * Construir filas con la nueva estructura: Objetivo → Metas → Indicadores
     */
    private function buildRows(): Collection {
        $pmi = Pmi::with('institucion.municipio')->findOrFail($this->pmiId);

        $this->municipio = $pmi?->institucion?->municipio?->nombre ?? '';
        $this->institucion = $pmi?->institucion?->nombre ?? '';
        $this->pmi = $pmi;

        $objetivos = PmiObjetivoVinculado::whereHas('factor', function ($query) {
            $query->where('pmi_id', $this->pmiId);
        })
            ->with('metas.indicadores.actividades')
            ->get();

        Log::info('Objetivos cargados: ' . json_encode($objetivos));
        return $objetivos;
    }

    /**
     * Construir la estructura de datos completa
     */
    private function buildDataStructure() {
        $currentRow = 12; // Inicia después de los encabezados (fila 12)

        foreach ($this->rows as $objetivo) {
            if ($objetivo->metas->isEmpty()) {
                // Objetivo sin metas
                $this->dataRows[] = [
                    'row' => $currentRow,
                    'objetivo' => $objetivo->descripcion,
                    'objetivo_range' => "B{$currentRow}:B{$currentRow}",
                    'indicador' => '',
                    'ano' => date('Y'),
                    'meta' => '',
                    'meta_range' => null,
                    'resultado' => '',
                ];
                $currentRow++;
            } else {
                $objetivoRowStart = $currentRow;

                foreach ($objetivo->metas as $meta) {
                    if ($meta->indicadores->isEmpty()) {
                        // Meta sin indicadores
                        $this->dataRows[] = [
                            'row' => $currentRow,
                            'objetivo' => null,
                            'objetivo_range' => null,
                            'indicador' => '',
                            'ano' => date('Y'),
                            'meta' => $meta->descripcion,
                            'meta_range' => "D{$currentRow}:D{$currentRow}",
                            'resultado' => '0%',
                        ];
                        $currentRow++;
                    } else {
                        $metaRowStart = $currentRow;

                        // Calcular el porcentaje ponderado de completitud de la meta
                        $totalIndicadores = $meta->indicadores->count();
                        $sumaPorcentajesIndicadores = 0;

                        foreach ($meta->indicadores as $indicador) {
                            // Calcular el porcentaje de completitud del indicador
                            // como la suma de los porcentajes de sus actividades
                            $totalActividades = $indicador->actividades->count();
                            $sumaPorcentajesActividades = 0;

                            if ($totalActividades > 0) {
                                foreach ($indicador->actividades as $actividad) {
                                    $accumulated = $actividad->accumulated ?? 0;
                                    $sumaPorcentajesActividades += $accumulated;
                                }

                                // Porcentaje del indicador = promedio de accumulated de sus actividades
                                $porcentajeIndicador = $sumaPorcentajesActividades / $totalActividades;
                            } else {
                                $porcentajeIndicador = 0;
                            }

                            $sumaPorcentajesIndicadores += $porcentajeIndicador;
                        }

                        // Porcentaje ponderado de la meta = promedio de porcentajes de indicadores
                        $porcentajeMeta = $totalIndicadores > 0
                            ? round($sumaPorcentajesIndicadores / $totalIndicadores, 2)
                            : 0;

                        foreach ($meta->indicadores as $indicador) {
                            // Construir descripción del indicador
                            $descripcionIndicador = "{$indicador->unidad_parcial} / {$indicador->unidad_total}";

                            $this->dataRows[] = [
                                'row' => $currentRow,
                                'objetivo' => null,
                                'objetivo_range' => null,
                                'indicador' => $descripcionIndicador,
                                'ano' => date('Y'),
                                'meta' => null,
                                'meta_range' => null,
                                'resultado' => null,
                            ];
                            $currentRow++;
                        }

                        // Marcar el rango de la meta
                        $metaRowEnd = $currentRow - 1;
                        if ($metaRowEnd >= $metaRowStart) {
                            $firstMetaIndex = array_search($metaRowStart, array_column($this->dataRows, 'row'));
                            if ($firstMetaIndex !== false) {
                                $this->dataRows[$firstMetaIndex]['meta'] = $meta->descripcion;
                                $this->dataRows[$firstMetaIndex]['meta_range'] = "D{$metaRowStart}:D{$metaRowEnd}";
                                $this->dataRows[$firstMetaIndex]['resultado'] = $porcentajeMeta . '%';
                            }
                        }
                    }
                }

                // Marcar el rango del objetivo
                $objetivoRowEnd = $currentRow - 1;
                if ($objetivoRowEnd >= $objetivoRowStart) {
                    $firstIndex = array_search($objetivoRowStart, array_column($this->dataRows, 'row'));
                    if ($firstIndex !== false) {
                        $this->dataRows[$firstIndex]['objetivo'] = $objetivo->descripcion;
                        $this->dataRows[$firstIndex]['objetivo_range'] = "B{$objetivoRowStart}:B{$objetivoRowEnd}";
                    }
                }
            }
        }
    }

    public function collection() {
        return new Collection([]);
    }

    public function title(): string {
        return 'Eval. Resultados PMI';
    }

    public function headings(): array {
        return [
            [''], // Fila 1 vacía
            ['', '', 'SECRETARÍA DE EDUCACIÓN DEPARTAMENTAL DEL QUINDÍO' . "\n" . 'DIRECCION  CALIDAD EDUCATIVA', '', '', '', '', '', '', '', '', ''], // Fila 2
            ['', '', 'EVALUACIÓN DE RESULTADOS FINALES' . "\n" . 'DEL PLAN DE MEJORAMIENTO INSTITUCIONAL', '', '', '', '', '', '', '', '', ''], // Fila 3
            [''], // Fila 4
            [''], // Fila 5
            ['', 'MUNICIPIO: ', $this->municipio, '', '', '', '', '', '', '', '', ''], // Fila 6
            ['', 'INSTITUCIÓN EDUCATIVA: ', $this->institucion, '', '', '', '', '', '', '', '', ''], // Fila 7
            ['', 'AÑO:', $this->pmi?->anio_inicio . ' - ' . $this->pmi?->anio_fin, '', '', '', '', '', '', '', '', ''], // Fila 8
            [''], // Fila 9
            ['', 'OBJETIVO', 'INDICADOR', 'AÑO', '', '', '', '', '', '', '', ''], // Fila 10
            ['', '', '', 'META', 'RESULTADO', '', '', '', '', '', '', ''] // Fila 11
        ];
    }

    public function columnWidths(): array {
        return [
            'A' => 1.42,
            'B' => 39.28,
            'C' => 51.71,
            'D' => 15.71,
            'E' => 39.28,
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
            'B10:E11' => [
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

                // Fusiones de celdas del encabezado
                $sheet->mergeCells('E2:E4'); // Logo
                $sheet->mergeCells('C3:D4');
                $sheet->mergeCells('B10:B11');
                $sheet->mergeCells('C10:C11');
                $sheet->mergeCells('C2:D2');
                $sheet->mergeCells('B2:B4');
                $sheet->mergeCells('C5:D5');
                $sheet->mergeCells('D10:E10');

                // Alturas de fila
                $rowHeights = [
                    1 => 15.75, 2 => 55.25, 3 => 21.0, 4 => 21.0, 5 => 4.15,
                    6 => 26.25, 7 => 26.25, 8 => 26.25, 9 => 10.15, 10 => 18.75,
                    11 => 24.75
                ];

                foreach ($rowHeights as $row => $height) {
                    $sheet->getRowDimension($row)->setRowHeight($height);
                }

                // Llenar las filas de datos desde la fila 12
                $currentRow = 12;
                foreach ($this->dataRows as $dataRow) {
                    // Objetivo (columna B)
                    if (isset($dataRow['objetivo']) && $dataRow['objetivo']) {
                        $sheet->setCellValue("B{$currentRow}", $dataRow['objetivo']);
                    }

                    // Indicador (columna C)
                    if (isset($dataRow['indicador']) && $dataRow['indicador']) {
                        $sheet->setCellValue("C{$currentRow}", $dataRow['indicador']);
                    }

                    // Meta (columna D, solo en la primera fila de cada meta)
                    if (isset($dataRow['meta']) && $dataRow['meta']) {
                        $sheet->setCellValue("D{$currentRow}", $dataRow['meta']);
                    }

                    // Resultado (columna E, solo en la primera fila de cada meta)
                    if (isset($dataRow['resultado']) && $dataRow['resultado']) {
                        $sheet->setCellValue("E{$currentRow}", $dataRow['resultado']);
                    }

                    $currentRow++;
                }

                // Ajustar altura de las filas de datos
                $totalRows = 11 + count($this->dataRows);
                for ($i = 12; $i <= $totalRows; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(18.0);
                }

                // Ajuste de texto en todas las celdas
                $sheet->getStyle("A1:E{$totalRows}")->getAlignment()->setWrapText(true);

                // Fusionar celdas para objetivos
                foreach ($this->dataRows as $dataRow) {
                    if (isset($dataRow['objetivo_range']) && $dataRow['objetivo_range']) {
                        $sheet->mergeCells($dataRow['objetivo_range']);
                        // Centrar verticalmente los objetivos
                        $sheet->getStyle($dataRow['objetivo_range'])->getAlignment()
                            ->setVertical(Alignment::VERTICAL_CENTER);
                    }

                    // Fusionar celdas para metas
                    if (isset($dataRow['meta_range']) && $dataRow['meta_range']) {
                        $sheet->mergeCells($dataRow['meta_range']);
                        // Centrar verticalmente las metas
                        $sheet->getStyle($dataRow['meta_range'])->getAlignment()
                            ->setVertical(Alignment::VERTICAL_CENTER);

                        // También fusionar la columna de resultado (E) con el mismo rango
                        $resultadoRange = str_replace('D', 'E', $dataRow['meta_range']);
                        $sheet->mergeCells($resultadoRange);
                        $sheet->getStyle($resultadoRange)->getAlignment()
                            ->setVertical(Alignment::VERTICAL_CENTER);
                    }
                }

                // Aplicar bordes a las filas de datos
                $lastDataRow = 11 + count($this->dataRows);
                $sheet->getStyle("B12:E{$lastDataRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Borde exterior MEDIUM para toda la tabla de datos
                $sheet->getStyle("B10:E{$lastDataRow}")->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM],
                    ],
                ]);

                // Centrar el contenido de las columnas D y E
                $sheet->getStyle("D12:E{$lastDataRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Bordes según especificaciones del encabezado
                $sheet->getStyle('B2:B4')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                $sheet->getStyle('C2:D4')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                $sheet->getStyle('E2:E4')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                $sheet->getStyle('B5:E10')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                // Bordes internos thin
                $sheet->getStyle('C6')->applyFromArray([
                    'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getStyle('C7')->applyFromArray([
                    'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getStyle('C8')->applyFromArray([
                    'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // Bordes para encabezados de tabla
                $sheet->getStyle('B10:E11')->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                // Borde exterior MEDIUM para encabezados
                $sheet->getStyle('B10:E11')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                // Agregar imagen en E2:E4
                $imagePath = public_path('imagenes/educacion_menu.png');
                if (file_exists($imagePath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo');
                    $drawing->setPath($imagePath);
                    $drawing->setCoordinates('E2');

                    $drawing->setOffsetX(0);
                    $drawing->setOffsetY(0);

                    // Altura: fila 2 (41.25) + fila 3 (21.0) + fila 4 (21.0) = 83.25 puntos
                    $heightInPixels = 83.25 * 1.33;
                    $drawing->setHeight((int)$heightInPixels);

                    $drawing->setWorksheet($sheet->getDelegate());
                }
            },
        ];
    }
}
