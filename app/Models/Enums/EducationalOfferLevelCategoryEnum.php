<?php

namespace App\Models\Enums;

/**
 * Nombres de los modulos
 */
enum EducationalOfferLevelCategoryEnum: string {
    case Level          = 'nivel';
    case SubLevel       = 'subnivel';
    case Specialty      = 'especialidad';
    case Emphasis       = 'énfasis';
    case Agreement      = 'convenio';
}
