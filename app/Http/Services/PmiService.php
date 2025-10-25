<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Pmi;
use App\Models\PMI\Enums\PmiEstadoEnum;
use App\Models\PMI\PmiComentarioFactor\Enums\PmiEstadoComentario;

class PmiService {
    public function __construct(
        private MailService $mailService
    ) {
    }

    public function aprobarPmi(Pmi $pmi): Result {
        $pmi->comentarios->each(function ($comentario) {
            $comentario->estado = PmiEstadoComentario::Historico->value;
            $comentario->save();
        });
        $pmi->estado = PmiEstadoEnum::Aprobado->value;
        $pmi->save();
        //rector
        $rector = $pmi->institucion->rector;
        // Enviar correo (retorna false si falla)
        $this->mailService->sendMail(
            email: $rector->email,
            subject: 'PMI aprobado',
            template: 'email.pmi.aprobado', // resources/views/emails/welcome.blade.php
            data:['usuario'=>$rector,'pmi'=>$pmi]
        );
        return Result::success(msg:"PMI aprobado correctamente");
    }
    public function devolverPmi(Pmi $pmi): Result {
        $cantidadComentariosPendientes = $pmi->comentarios
                    ->where('estado', PmiEstadoComentario::Activo->value)
                    ->count();
        if ($cantidadComentariosPendientes == 0 ) {
            return Result::error(msg: 'Debe tener al menos un comentario.');
        }
        $pmi->estado = PmiEstadoEnum::Proceso->value;
        $pmi->save();
        //rector
        $rector = $pmi->institucion->rector;
        // Enviar correo (retorna false si falla)
        $this->mailService->sendMail(
            email: $rector->email,
            subject: 'PMI con observaciones',
            template: 'email.pmi.devuelto', // resources/views/emails/welcome.blade.php
            data:['usuario'=>$rector,'pmi'=>$pmi, 'cantidadComentariosPendientes' => $cantidadComentariosPendientes]
        );
        return Result::success(msg:"PMI devuelto correctamente");
    }
}
