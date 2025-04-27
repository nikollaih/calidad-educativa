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
        'institucion',
        'atencionGrupoPoblacionales',
        'prevencionRiesgos',
        'programasServicioSocial'
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
     * Relación con GcAtencionGrupoPoblacionales (1 a 1)
     * Note: Fixed apparent typo in original filename (Robiacionales -> Poblacionales)
     */
    public function atencionGrupoPoblacionales()
    {
        return $this->hasOne(GcAtencionGruposPoblacionales::class, 'gestion_comunidad_id');
    }

    /**
     * Relación con GcPrevencionRiesgos (1 a 1)
     * Note: Fixed apparent typo in original filename (Prevenden -> Prevencion)
     */
    public function prevencionRiesgos()
    {
        return $this->hasOne(GcPrevencionRiesgos::class, 'gestion_comunidad_id');
    }

    /**
     * Relación con GcProgramasServicioSocial (1 a 1)
     */
    public function programasServicioSocial()
    {
        return $this->hasOne(GcProgramaServicioSocial::class, 'gestion_comunidad_id');
    }
}