<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyectosActividadesHasAdjunto extends Model
{
    use HasFactory;

    protected $table = 'proyectos_actividades_has_adjuntos';

    protected $fillable = [
        'proyecto_actividad_id',
        'adjunto_id',
    ];

    /**
     * Relación: Un registro de adjunto pertenece a una actividad de proyecto.
     */
    public function proyectoActividad(): BelongsTo
    {
        return $this->belongsTo(ProyectosActividad::class, 'proyecto_actividad_id');
    }

    /**
     * Relación: Un registro de adjunto pertenece a un adjunto.
     */
    public function adjunto(): BelongsTo
    {
        return $this->belongsTo(Adjunto::class, 'adjunto_id');
    }
}
