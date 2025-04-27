<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionAcademica extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'gestion_academica';

    /**
     * Relaciones que se cargarán automáticamente
     */
    public $with = [
        'institucion',
        'gestionAulas',
        'practicasPedagogicas',
        'seguimientosAcademicos',
        'disenosPedagogicos',
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
    
    /**
     * Relación con GdGestionAulas (1 a 1)
     * Note: Fixed apparent typo in original filename (Cestion -> Gestión)
     */
    public function gestionAulas()
    {
        return $this->hasOne(GaGestionAulas::class, 'gestion_academica_id');
    }

    /**
     * Relación con GalPracticasPedagogicas (1 a 1)
     */
    public function practicasPedagogicas()
    {
        return $this->hasOne(GaPracticasPedagogicas::class, 'gestion_academica_id');
    }

    /**
     * Relación con GdSeguimientosAcademicos (1 a 1)
     */
    public function seguimientosAcademicos()
    {
        return $this->hasOne(GaSeguimientosAcademicos::class, 'gestion_academica_id');
    }

    
    /**
     * Relación con GaDisenosPedagogicos (1 a 1)
     */
    public function disenosPedagogicos()
    {
        return $this->hasOne(GaDisenosPedagogicos::class, 'gestion_academica_id');
    }
}