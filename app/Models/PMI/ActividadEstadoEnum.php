<?php
namespace App\Models\PMI;

enum ActividadEstadoEnum: string
{
    case SIN_INICIAR = 'Sin iniciar';
    case EN_PROGRESO = 'En progreso';
    case COMPLETADA = 'Completada';

    public function label(): string
    {
        return match ($this) {
            self::SIN_INICIAR => 'Sin iniciar',
            self::EN_PROGRESO => 'En progreso',
            self::COMPLETADA => 'Completada',
        };
    }
}
