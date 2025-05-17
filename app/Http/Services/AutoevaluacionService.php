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
               return  Result::success('Actualmente tienes '. $cantidadTotalNotas - $cantidadTotalNotasCalificadas . ' notas pendientes por calificar.');
            }
            return Result::error(msg:' No tienes notas pendientes por calificar.');
    }

}
