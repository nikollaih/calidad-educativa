<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Pmi;
use App\Models\PMI\Enums\PmiEstadoEnum;
use App\Models\PMI\PmiComentarioFactor\Enums\PmiEstadoComentario;

class PmiService {
    public function aprobarPmi(Pmi $pmi): Result {
        $pmi->comentarios->each(function ($comentario) {
            $comentario->estado = PmiEstadoComentario::Historico->value;
            $comentario->save();
        });
        $pmi->estado = PmiEstadoEnum::Aprobado->value;
        $pmi->save();
        return Result::success(msg:"PMI aprobado correctamente");
    }
    public function devolverPmi(Pmi $pmi): Result {
        $tieneComentariosPendientes = $pmi->comentarios
                    ->where('estado', PmiEstadoComentario::Activo->value)
                    ->count() == 0
                        ? true
                        : false;
        if ($tieneComentariosPendientes) {
            return Result::error(msg: 'Debe tener al menos un comentario.');
        }
        $pmi->estado = PmiEstadoEnum::Proceso->value;
        $pmi->save();
        return Result::success(msg:"PMI devuelto correctamente");
    }
}
