<?php

namespace App\Exports;

use App\Models\PamAccion;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PamExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize {
    /**
     * Obtiene la colección completa de acciones PAM con todas sus relaciones
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
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
    public function headings(): array
    {
        return [
            // 'ID Acción',
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
            // 'Estado',
            'Creado el',
            // 'Actualizado el'
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
            // $accion->id,
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
            // $this->getEstado($accion),
            $accion->created_at->format('Y-m-d H:i:s'),
            // $accion->updated_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Aplica estilos al archivo Excel
     * 
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet) {
        $columns = range('A', 'Q');
        $columnWidth = 20;

        // Set fixed width for all specified columns
        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidth);
            $sheet->getColumnDimension($column)->setAutoSize(false);
        }

        // Aplicar ajuste de texto a todas las columnas
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();
        
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        return [
            // Estilo para la cabecera (solo negrilla)
            1 => [
                'font' => [
                    'bold' => true
                ]
            ],
        ];
    }

    /**
     * Determina el estado de la acción basado en las fechas
     * 
     * @param PamAccion $accion
     * @return string
     */
    private function getEstado($accion): string
    {
        $now = now();
        $fechaInicio = \Carbon\Carbon::parse($accion->fecha_inicio);
        $fechaFinal = \Carbon\Carbon::parse($accion->fecha_final);

        if ($now->lt($fechaInicio)) {
            return 'Pendiente';
        } elseif ($now->between($fechaInicio, $fechaFinal)) {
            return 'En Proceso';
        } else {
            return 'Vencida';
        }
    }
}