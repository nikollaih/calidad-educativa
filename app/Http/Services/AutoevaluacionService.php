<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Autoevaluacion;
use App\Models\Calificacion;
use Illuminate\Support\Collection;

class AutoevaluacionService {

    const PUNTAJE_MINIMO_PARA_PMI = 4;

    // Permite almacenar un adjunto
    public function tieneNotasPendientes(Autoevaluacion $autoevaluacion):Result {
            $cantidadTotalNotas = Calificacion::count();
            $cantidadTotalNotasCalificadas = $autoevaluacion->notas()->count();

            $tieneNotasPendientes  = $cantidadTotalNotas - $cantidadTotalNotasCalificadas != 0;
            if( $tieneNotasPendientes) {
                // Obtener los IDs de las notas ya calificadas
                $notasCalificadasIds = $autoevaluacion->notas()->pluck('indice_calificacion');

                // Obtener la primera nota que no está calificada
                $primeraNotaSinCalificar = Calificacion::whereNotIn('indice', $notasCalificadasIds)
                    ->orderBy('indice')
                    ->first();

               return  Result::success('Actualmente tienes '. $primeraNotaSinCalificar->indice . ' ' . $primeraNotaSinCalificar->nombre .
                   ' y otras '
                   . $cantidadTotalNotas - ($cantidadTotalNotasCalificadas + 1) . ' notas pendientes por calificar.');
            }
            return Result::error(msg:' No tienes notas pendientes por calificar.');
    }
    public function obtenerNotasPendientes(Autoevaluacion $autoevaluacion):Collection {
        // Extrae los índices de calificación ya respondidos
        $indicesRespondidos = $autoevaluacion->notas()->pluck('indice_calificacion');

        // Retorna las calificaciones cuyo índice no esté en la lista de respondidos
        return Calificacion::whereNotIn('indice', $indicesRespondidos)
            ->orderBy('indice')
            ->get();
    }
    public function asignarPmiFactoresCriticos(Autoevaluacion $autoevaluacion,int $pmiId):Collection {
        $factoresCriticos = $autoevaluacion->factoresCriticos;

        $asignados = $factoresCriticos->filter(function ($factor) {
            return $factor->valor >= self::PUNTAJE_MINIMO_PARA_PMI;
        })->each(function ($factor) use ($pmiId) {
            $factor->pmi_id = $pmiId;
            $factor->save();
        });

        return $asignados->values();
    }
}
