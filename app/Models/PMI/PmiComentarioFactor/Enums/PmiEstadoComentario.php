<?php

namespace App\Models\PMI\PmiComentarioFactor\Enums;

/*
 * Son los estado posibles para un plan de mejoramiento institucional
 * */
enum PmiEstadoComentario: string {
    case Activo    = 'activo';
    case Historico = 'historico';
    case Resuelto  = 'resuelto';
}
