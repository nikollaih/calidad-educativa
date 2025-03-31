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


    public static function toArray(): array
    {
        return array_combine(
            array_map(fn($case) => $case->name, self::cases()),
            array_map(fn($case) => $case->value, self::cases())
        );
    }
  public static function getValueByCase(string $case): string
    {
       foreach (self::cases() as $enumCase) {
            if ($enumCase->name === $case) {
                return $enumCase->value;
            }
        }
        return null; // Retorna null si no encuentra coincidencia
    }
}
