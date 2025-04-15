<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionComunidad extends Model {

    protected $table = 'gestion_comunidad';

    public  $with = [
        'anexoProgramaServicioSocial',
        'anexoPrevencionRiesgosFisicos',
        'anexoProyectoEscuelaPadres',
    ];

    protected $fillable = [
        'institution_id',
        'atencion_grupos_vulnerabilidad',
        'necesidades_expectativas_estudiantes',
        'proyectos_vida',
        'escuela_padres',
        'oferta_servicios_comunidad',
        'programa_servicio_social',
        'anexo_programa_servicio_social',
        'anexo_proyecto_escuela_padres',
        'prevencion_riesgos_fisicos',
        'anexo_prevencion_riesgos_fisicos',
        'prevencion_riesgos_psicosociales',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
    
    public function anexoProgramaServicioSocial (){
        return $this->belongsTo(Adjunto::class, 'anexo_programa_servicio_social');
    }
    
    public function anexoPrevencionRiesgosFisicos (){
        return $this->belongsTo(Adjunto::class, 'anexo_prevencion_riesgos_fisicos');
    }
    
    public function anexoProyectoEscuelaPadres (){
        return $this->belongsTo(Adjunto::class, 'anexo_proyecto_escuela_padres');
    }
}
