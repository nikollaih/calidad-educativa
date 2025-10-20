<?php

namespace App\Models\PMI\Enums;

/*
 * Son los estado posibles para un plan de mejoramiento institucional
 * */
enum PmiEstadoEnum: string {
    case Proceso    = 'Proceso';
    case Presentado = 'Presentado';
    case Aprobado   = 'Aprobado';
}
