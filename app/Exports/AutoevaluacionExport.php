<?php

namespace App\Exports;

use App\Models\Autoevaluacion;
use App\Models\GrupoCalificacion;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AutoevaluacionExport implements WithMultipleSheets {
    private Autoevaluacion $autoevaluacion;

    /** @var array<string, GrupoCalificacion> */
    private array $gruposPorIndice;

    public function __construct(int $autoevaluacionId) {
        $this->autoevaluacion = Autoevaluacion::with(['notas', 'institucion'])->findOrFail($autoevaluacionId);
        $this->gruposPorIndice = GrupoCalificacion::with('hijos.calificaciones')
            ->whereNull('padre_id')
            ->get()
            ->keyBy('indice')
            ->all();
    }

    public function sheets(): array {
        $hojas = [
            '1' => 'Directiva',
            '2' => 'Académica',
            '3' => 'Administrativa',
            '4' => 'De la comunidad',
        ];

        $notasSeleccionadas = $this->autoevaluacion->notas->keyBy('indice_calificacion');

        return collect($hojas)->map(function (string $nombreHoja, string $indiceGrupo) use ($notasSeleccionadas) {
            return new AutoevaluacionGestionSheet(
                grupo: $this->gruposPorIndice[$indiceGrupo] ?? null,
                notasSeleccionadas: $notasSeleccionadas,
                nombreHoja: $nombreHoja,
                anioVigencia: $this->autoevaluacion->anio_vigencia,
                institucion: $this->autoevaluacion->institucion?->nombre ?? '',
            );
        })->all();
    }
}
