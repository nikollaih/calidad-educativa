<?php
namespace App\Models\Enums;

enum TitularityTypes: string
{
    case MUNICIPIO = 'Municipio';
    case DEPARTAMENTO = 'Departamento';
    case COMITE_CAFETEROS = 'Comité de Cafeteros';
    case OTRO = 'Otro';
    case EN_ARRIENDO = 'En arriendo';

    public function label(): string
    {
        return match ($this) {
            self::MUNICIPIO => 'Municipio',
            self::DEPARTAMENTO => 'Departamento',
            self::COMITE_CAFETEROS => 'Comité de Cafeteros',
            self::OTRO => 'Otro',
            self::EN_ARRIENDO => 'En arriendo',
        };
    }
}
