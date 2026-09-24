<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RedesActividad extends Model
{
    use HasFactory;

    protected $table = 'redes_actividades';

    protected $fillable = [
        'red_aprendizaje_id',
        'fecha',
        'descripcion',
    ];

    /**
     * Relación: Una actividad pertenece a una red de aprendizaje.
     */
    public function redAprendizaje(): BelongsTo
    {
        return $this->belongsTo(RedesAprendizaje::class, 'red_aprendizaje_id');
    }

    /**
     * Relación: Una actividad puede tener muchos adjuntos.
     */
    public function adjuntos(): HasMany
    {
        return $this->hasMany(RedesActividadesHasAdjunto::class, 'red_actividad_id');
    }
}
