<?php

namespace App\Exports;

use App\Models\Pmi;
use App\Models\PmiMetaVinculada;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class PmiSintesisExport implements WithTitle, WithColumnWidths, WithEvents {
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
     * Construir filas con la nueva estructura: Meta → Indicadores → Actividades
     */
    private function buildRows(): Collection {
        $pmi = Pmi::with(
            'institucion.municipio',
        )->findOrFail($this->pmiId);

        $this->municipio = $pmi?->institucion?->municipio?->nombre;
        $this->institucion = $pmi?->institucion?->nombre;
        $this->pmi = $pmi;

        $metas = PmiMetaVinculada::whereHas('objetivo.factor', function ($query) {
            $query->where('pmi_id', $this->pmiId);
        })
            ->with('indicadores.actividades')
            ->get();

        return $metas;
    }

    /**
     * Construir la estructura de datos completa
     */
    private function buildDataStructure() {
        $currentRow = 11; // Inicia después de los encabezados (fila 11)

        foreach ($this->rows as $meta) {
            if ($meta->indicadores->isEmpty()) {
                // Meta sin indicadores
                $this->dataRows[] = [
                    'row' => $currentRow,
                    'meta' => $meta->descripcion,
                    'meta_range' => "B{$currentRow}:B{$currentRow}",
                    'indicador' => '',
                    'indicador_range' => null,
                    'instrumentos' => '',
                    'responsables' => '',
                    'frecuencia' => '',
                ];
                $currentRow++;
            } else {
                $metaRowStart = $currentRow;

                foreach ($meta->indicadores as $indicador) {
                    $indicadorTexto = "{$indicador->unidad_parcial} / {$indicador->unidad_total}";

                    if ($indicador->actividades->isEmpty()) {
                        // Indicador sin actividades
                        $this->dataRows[] = [
                            'row' => $currentRow,
                            'meta' => null,
                            'meta_range' => null,
                            'indicador' => $indicadorTexto,
                            'indicador_range' => "C{$currentRow}:C{$currentRow}",
                            'instrumentos' => '',
                            'responsables' => '',
                            'frecuencia' => '',
                        ];
                        $currentRow++;
                    } else {
                        $indicadorRowStart = $currentRow;

                        foreach ($indicador->actividades as $actividad) {
                            $responsables = $actividad->responsables ?? '';
                            $instrumentos = $actividad->instrumentos_recoleccion ?? '';

                            $this->dataRows[] = [
                                'row' => $currentRow,
                                'meta' => null,
                                'meta_range' => null,
                                'indicador' => null,
                                'indicador_range' => null,
                                'instrumentos' => $instrumentos,
                                'responsables' => $responsables,
                                'frecuencia' => $responsables,
                            ];
                            $currentRow++;
                        }

                        // Marcar el rango del indicador
                        if ($indicador->actividades->count() > 0) {
                            $indicadorRowEnd = $currentRow - 1;
                            $this->dataRows[$indicadorRowStart - 11]['indicador'] = $indicadorTexto;
                            $this->dataRows[$indicadorRowStart - 11]['indicador_range'] = "C{$indicadorRowStart}:C{$indicadorRowEnd}";
                        }
                    }
                }

                // Marcar el rango de la meta
                $metaRowEnd = $currentRow - 1;
                if ($metaRowEnd >= $metaRowStart) {
                    $this->dataRows[$metaRowStart - 11]['meta'] = $meta->descripcion;
                    $this->dataRows[$metaRowStart - 11]['meta_range'] = "B{$metaRowStart}:B{$metaRowEnd}";
                }
            }
        }
    }

    public function title(): string {
        return 'Síntesis seguimiento PMI';
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

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ========== ESCRIBIR ENCABEZADOS ==========
                $sheet->setCellValue('C2', "SECRETARÍA DE EDUCACIÓN DEPARTAMENTAL DEL QUINDÍO\nDIRECCION  CALIDAD EDUCATIVA");
                $sheet->setCellValue('C3', "SÍNTESIS DE SEGUIMIENTO AL PLAN DE MEJORAMIENTO INSTITUCIONAL");
                $sheet->setCellValue('B6', 'MUNICIPIO: ');
                $sheet->setCellValue('C6', $this->municipio);
                $sheet->setCellValue('B7', 'INSTITUCIÓN EDUCATIVA: ');
                $sheet->setCellValue('C7', $this->institucion);
                $sheet->setCellValue('B8', 'AÑO:');
                $sheet->setCellValue('C8', $this->pmi?->anio_inicio . ' - ' . $this->pmi?->anio_fin);

                // Encabezados de tabla
                $sheet->setCellValue('B10', 'META');
                $sheet->setCellValue('C10', 'INDICADORES');
                $sheet->setCellValue('D10', 'INSTRUMENTOS DE RECOLECCIÓN');
                $sheet->setCellValue('E10', 'RESPONSABLES');
                $sheet->setCellValue('F10', 'FRECUENCIA DE RECOLECCIÓN');

                // ========== ESCRIBIR DATOS ==========
                $processedMetas = [];
                $processedIndicadores = [];

                foreach ($this->dataRows as $rowData) {
                    $row = $rowData['row'];

                    // Escribir META
                    if ($rowData['meta'] && $rowData['meta_range'] && !in_array($rowData['meta_range'], $processedMetas)) {
                        $sheet->setCellValue("B{$row}", $rowData['meta']);
                        if (strpos($rowData['meta_range'], ':') !== false) {
                            $sheet->mergeCells($rowData['meta_range']);
                        }
                        $processedMetas[] = $rowData['meta_range'];
                    }

                    // Escribir INDICADOR
                    if ($rowData['indicador'] && $rowData['indicador_range'] && !in_array($rowData['indicador_range'], $processedIndicadores)) {
                        $sheet->setCellValue("C{$row}", $rowData['indicador']);
                        if (strpos($rowData['indicador_range'], ':') !== false) {
                            $sheet->mergeCells($rowData['indicador_range']);
                        }
                        $processedIndicadores[] = $rowData['indicador_range'];
                    }

                    // Escribir INSTRUMENTOS, RESPONSABLES, FRECUENCIA
                    $sheet->setCellValue("D{$row}", $rowData['instrumentos']);
                    $sheet->setCellValue("E{$row}", $rowData['responsables']);
                    $sheet->setCellValue("F{$row}", $rowData['frecuencia']);
                }

                // ========== FUSIONES DE CELDAS DEL ENCABEZADO ==========
                $sheet->mergeCells('F2:F4');
                $sheet->mergeCells('C3:E4');
                $sheet->mergeCells('C2:E2');
                $sheet->mergeCells('B2:B4');
                $sheet->mergeCells('C5:F5');

                // ========== ALTURAS DE FILA ==========
                $rowHeights = [
                    1 => 15.75, 2 => 41.25, 3 => 21.0, 4 => 21.0, 5 => 4.15,
                    6 => 26.25, 7 => 26.25, 8 => 26.25, 9 => 10.15, 10 => 41.25,
                ];

                foreach ($rowHeights as $row => $height) {
                    $sheet->getRowDimension($row)->setRowHeight($height);
                }

                // Altura para filas de datos
                $dataRowCount = count($this->dataRows);
                for ($i = 11; $i <= (10 + $dataRowCount); $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(18.0);
                }

                // ========== ESTILOS ==========
                $lastRow = 10 + $dataRowCount;

                // Estilos de encabezado
                $sheet->getStyle('C2')->applyFromArray([
                    'font' => ['name' => 'Arial', 'size' => 14, 'bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_BOTTOM, 'wrapText' => true]
                ]);

                $sheet->getStyle('C3')->applyFromArray([
                    'font' => ['name' => 'Arial', 'size' => 14, 'bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]
                ]);

                $sheet->getStyle('B6:B8')->applyFromArray([
                    'font' => ['name' => 'Calibri', 'size' => 14, 'bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_GENERAL, 'vertical' => Alignment::VERTICAL_BOTTOM]
                ]);
                $sheet->getStyle('C6:C8')->applyFromArray([
                    'font' => ['name' => 'Calibri', 'size' => 11, 'bold' => false],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_GENERAL, 'vertical' => Alignment::VERTICAL_BOTTOM]
                ]);

                $sheet->getStyle('B10:F10')->applyFromArray([
                    'font' => ['name' => 'Calibri', 'size' => 12, 'bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFC0C0C0']]
                ]);

                // Ajuste de texto y alineación en datos
                $sheet->getStyle("B11:F{$lastRow}")->applyFromArray([
                    'alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP, 'horizontal' => Alignment::HORIZONTAL_LEFT]
                ]);

                // ========== BORDES ==========
                // Bordes del encabezado
                $sheet->getStyle('B2:B4')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                $sheet->getStyle('C2:F4')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                $sheet->getStyle('F2:F4')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                $sheet->getStyle('B5:F10')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                $sheet->getStyle('C6')->applyFromArray([
                    'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getStyle('C7')->applyFromArray([
                    'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getStyle('C8')->applyFromArray([
                    'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                $sheet->getStyle('B10:F10')->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                $sheet->getStyle('B10:F10')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                // Bordes para las filas de datos
                $sheet->getStyle("B11:F{$lastRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                $sheet->getStyle("B11:F{$lastRow}")->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);

                // ========== AGREGAR IMAGEN ==========
                $imagePath = public_path('imagenes/educacion_menu.png');
                if (file_exists($imagePath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo');
                    $drawing->setPath($imagePath);
                    $drawing->setCoordinates('F2');
                    $drawing->setOffsetX(0);
                    $drawing->setOffsetY(0);
                    $heightInPixels = 83.25 * 1.33;
                    $drawing->setHeight((int)$heightInPixels);
                    $drawing->setWorksheet($sheet);
                }
            },
        ];
    }
}
