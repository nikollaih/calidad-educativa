<?php

namespace App\Models\Enums;

enum State: string {
    case Abierta = 'abierta';
    case Cerrada = 'cerrada';

    public function label(): string {
        return match ($this) {
            self::Abierta => 'Abierta',
            self::Cerrada => 'Cerrada',
        };
    }
}
