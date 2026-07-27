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
        'representante_id',
        'nombre',
        'descripcion',
        'numero_contacto',
    ];


    /**
     * Relación: Un proyecto transversal pertenece a un representante (usuario).
     */
    public function representante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'representante_id');
    }

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

    /**
     * Relacion con los integrantes
     */
    public function integrantes(): HasMany
    {
        return $this->hasMany(ProyectoIntegrante::class, 'proyecto_transversal_id');
    }
}
