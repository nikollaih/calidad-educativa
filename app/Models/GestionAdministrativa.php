<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionAdministrativa extends Model {

    protected $table = 'gestion_administrativa';

    // Relaciones a cargar automáticamente
    public $with = [
        'institucion'
    ];

    // Campos asignables masivamente
    protected $fillable = [
        'institution_id',
        'created_at',
        'updated_at'
    ];

    // Campos que deben ser tratados como fechas
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con la institución
     */
    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}