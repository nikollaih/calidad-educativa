<?php

namespace App\Models\Enums\PmiActividad;

enum FrecuenciaRecoleccionEnum: string {
    case Diaria     = 'Diaria';
    case Semanal    = 'Semanal';
    case Mensual    = 'Mensual';
    case Bimensual  = 'Bimensual';
    case Trimestral = 'Trimestral';
    case Semestral  = 'Semestral';
    case Anual      = 'Anual';
}
