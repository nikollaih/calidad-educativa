<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedIntegrante extends Model
{
    use HasFactory;

    protected $table = 'redes_integrantes';

    protected $fillable = [
        'red_aprendizaje_id',
        'institucion_id',
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

    /**
     * Relación: Un integrante pertenece a una institucion.
     */
    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
}
