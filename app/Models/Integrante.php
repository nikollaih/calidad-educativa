<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Integrante extends Model
{
    use HasFactory;

    protected $table = 'integrantes';

    protected $fillable = [
        'red_aprendizaje_id',
        'nombre',
        'telefono',
        'correo',
        'rol',
    ];

    /**
     * Relación: Un integrante pertenece a una red de aprendizaje.
     */
    public function redAprendizaje(): BelongsTo
    {
        return $this->belongsTo(RedesAprendizaje::class, 'red_aprendizaje_id');
    }
}
