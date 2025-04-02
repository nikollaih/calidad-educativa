<?php

namespace App\Models\Enums;

/**
 * Nombres de los modulos
 */
enum EducationalOfferLevelCategoryEnum: string {
    case Level          = 'nivel';
    case SubLevel       = 'subnivel';
    case Specialty      = 'especialidad';
    case PreSchool      = 'preescolar';
    case Primary        = 'primaria';
    case Secondary      = 'secundaria';
    case Emphasis       = 'énfasis';
    case Agreement      = 'convenio';

    public static function toArray(): array
    {
        return array_combine(
            array_map(fn($case) => $case->name, self::cases()),
            array_map(fn($case) => $case->value, self::cases())
        );
    }
}
