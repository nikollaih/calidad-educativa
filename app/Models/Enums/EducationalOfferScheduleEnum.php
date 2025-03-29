<?php

namespace App\Models\Enums;

/**
 * Nombres de los modulos
 */
enum EducationalOfferScheduleEnum: string {
    case Morning           = 'mañana';
    case Afternoon         = 'tarde';
    case Night             = 'noche';
    case Unique            = 'única';
    case AdultEducation    = 'educación adultos';
}
