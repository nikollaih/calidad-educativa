<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProyectosTransversal extends Model
{
    use HasFactory;

    protected $table = 'proyectos_transversales';

    protected $fillable = [
        'institucion_id',
        'acto_administrativo_id',
        'nombre',
        'descripcion',
        'numero_contacto',
    ];

    /**
     * Relación: Un proyecto transversal pertenece a una institución.
     */
    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    /**
     * Relación: Un proyecto transversal tiene un acto administrativo.
     */
    public function actoAdministrativo(): BelongsTo
    {
        return $this->belongsTo(Adjunto::class, 'acto_administrativo_id');
    }

    /**
     * Relación: Un proyecto transversal tiene muchas actividades.
     */
    public function actividades(): HasMany
    {
        return $this->hasMany(ProyectosActividad::class, 'proyecto_transversal_id');
    }
}
