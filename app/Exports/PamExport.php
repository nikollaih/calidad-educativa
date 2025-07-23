<?php

namespace App\Exports;

use App\Models\PamAccion;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Exporta tabla del PAM a Excel
 * 
 * @author Cristian Camilo Palacio N. 17 - Jul - 2025
 */
class PamExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize {

    /**
     * Obtiene la colección completa de acciones PAM con todas sus relaciones
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return PamAccion::with([
            'indicador.meta.objetivoEstrategico.metaPlanDesarrollo.subproceso.proceso.componente',
            'user'
        ])->get();
    }

    /**
     * Define las cabeceras del archivo Excel
     * 
     * @return array
     */
    public function headings(): array {
        return [
            'Componente',
            'Proceso',
            'Subproceso',
            'Meta Plan Desarrollo',
            'Objetivo Estratégico',
            'Meta',
            'Indicador',
            'Acción',
            'Responsable',
            'Email Responsable',
            'Recursos',
            'Fecha Inicio',
            'Fecha Final',
            'Creado el',
        ];
    }

    /**
     * Mapea los datos de cada fila
     * 
     * @param mixed $accion
     * @return array
     */
    public function map($accion): array {
        return [
            $accion->indicador->meta->objetivoEstrategico->metaPlanDesarrollo->first()->subproceso->proceso->componente->descripcion ?? 'N/A',
            $accion->indicador->meta->objetivoEstrategico->metaPlanDesarrollo->first()->subproceso->proceso->descripcion ?? 'N/A',
            $accion->indicador->meta->objetivoEstrategico->metaPlanDesarrollo->first()->subproceso->descripcion ?? 'N/A',
            $accion->indicador->meta->objetivoEstrategico->metaPlanDesarrollo->first()->descripcion ?? 'N/A',
            $accion->indicador->meta->objetivoEstrategico->descripcion ?? 'N/A',
            $accion->indicador->meta->descripcion ?? 'N/A',
            $accion->indicador->descripcion ?? 'N/A',
            $accion->descripcion,
            $accion->nombre_responsable,
            $accion->user->email ?? 'N/A',
            $accion->recursos,
            Carbon::parse($accion->fecha_inicio)->format('Y-m-d'),
            Carbon::parse($accion->fecha_final)->format('Y-m-d'),
            $accion->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Aplica estilos al archivo Excel
     * 
     * @param Worksheet $sheet
     * @return array
     */
public function styles(Worksheet $sheet)
    {
        $columns = range('A', 'Q');
        $columnWidth = 20;

        // Agrega ancho fijo a las columnas seleccionadas y desactiva autoajuste
        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidth);
            $sheet->getColumnDimension($column)->setAutoSize(false);
        }

        // Obtener la última columna y fila usadas en la hoja
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();
        
        // Aplicar ajuste de texto y alineación vertical superior a todas las celdas usadas
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        // Definir el rango completo de celdas que contendrán datos para aplicar bordes
        $fullRange = 'A1:' . $highestColumn . $highestRow;

        return [
            // Estilo para la cabecera (fila 1)
            1 => [
                'font' => [
                    'bold' => true, // Texto en negrita
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID, // Tipo de relleno sólido
                    'startColor' => [
                        'argb' => 'FFFFCCCC', // Color rojo claro (ARGB: Alpha, Red, Green, Blue)
                                              // FF para opacidad completa, FFCCCC para un rojo pastel
                    ],
                ],
            ],
            // Estilo para todas las celdas con datos (incluyendo la cabecera)
            // Esto aplicará bordes a todo el rango de datos.
            $fullRange => [
                'borders' => [
                    'allBorders' => [ // Aplica bordes a todos los lados de las celdas
                        'borderStyle' => Border::BORDER_THIN, // Estilo de borde delgado
                        'color' => ['argb' => 'FF000000'],    // Color del borde (negro)
                    ],
                ],
            ],
        ];
    }
}