<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProyectosActividad extends Model
{
    use HasFactory;

    protected $table = 'proyectos_actividades';

    protected $fillable = [
        'proyecto_transversal_id',
        'fecha',
        'descripcion',
    ];

    /**
     * Relación: Una actividad de proyecto pertenece a un proyecto transversal.
     */
    public function proyectoTransversal(): BelongsTo
    {
        return $this->belongsTo(ProyectosTransversal::class, 'proyecto_transversal_id');
    }

    /**
     * Relación: Una actividad de proyecto puede tener muchos adjuntos.
     */
    public function adjuntos(): HasMany
    {
        return $this->hasMany(ProyectosActividadesHasAdjunto::class, 'proyecto_actividad_id');
    }
}
