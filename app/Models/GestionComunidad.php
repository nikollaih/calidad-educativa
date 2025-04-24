<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionComunidad extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'gestion_comunidad';

    /**
     * Relaciones que se cargarán automáticamente
     */
    public $with = [
        'institucion'
    ];

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'institution_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Conversiones de tipos
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con la institución
     */
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institution_id');
    }
}