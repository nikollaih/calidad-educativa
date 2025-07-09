<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Autoevaluacion;
use App\Models\Calificacion;

class AutoevaluacionService {
    // Permite almacenar un adjunto
    public function tieneNotasPendientes(Autoevaluacion $autoevaluacion):Result {
            $cantidadTotalNotas = Calificacion::count();
            $cantidadTotalNotasCalificadas = $autoevaluacion->notas()->count();

            $tieneNotasPendientes  = $cantidadTotalNotas - $cantidadTotalNotasCalificadas != 0;
            if( $tieneNotasPendientes) {
                // Obtener los IDs de las notas ya calificadas
                $notasCalificadasIds = $autoevaluacion->notas()->pluck('id');

                // Obtener la primera nota que no está calificada
                $primeraNotaSinCalificar = Calificacion::whereNotIn('id', $notasCalificadasIds)
                    ->orderBy('id')
                    ->first();

               return  Result::success('Actualmente tienes '. $primeraNotaSinCalificar->indice . ' ' . $primeraNotaSinCalificar->nombre .
                   ' y otras '
                   . $cantidadTotalNotas - ($cantidadTotalNotasCalificadas + 1) . ' notas pendientes por calificar.');
            }
            return Result::error(msg:' No tienes notas pendientes por calificar.');
    }

}
