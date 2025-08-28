<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RedesAprendizaje extends Model
{
    use HasFactory;

    protected $table = 'redes_aprendizaje';

    protected $fillable = [
        'acto_administrativo_id',
        'representante_id',
        'nombre',
        'correo',
        'descripcion',
        'numero_contacto',
    ];

    /**
     * Relación: Una red de aprendizaje pertenece a un representante (usuario).
     */
    public function representante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'representante_id');
    }

    /**
     * Relación: Una red de aprendizaje tiene un acto administrativo.
     */
    public function actoAdministrativo(): BelongsTo
    {
        return $this->belongsTo(Adjunto::class, 'acto_administrativo_id');
    }

    /**
     * Relación: Una red de aprendizaje tiene muchos integrantes.
     */
    public function integrantes(): HasMany
    {
        return $this->hasMany(Integrante::class, 'red_aprendizaje_id');
    }

    /**
     * Relación: Una red de aprendizaje tiene muchas actividades.
     */
    public function actividades(): HasMany
    {
        return $this->hasMany(RedesActividad::class, 'red_aprendizaje_id');
    }
}
