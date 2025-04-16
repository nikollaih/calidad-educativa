<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionAcademica extends Model {

    protected $table = 'gestion_academica';
    
    public  $with = [
        'anexoPlanEstudios',
        'anexoEnfoquePedagogico',
        'anexoAnalisisJornada',
        'anexoSistemaEvaluacion',
        'anexosPlanesAula',
        'anexosTemasEnsenanza',
        'anexoInformeEstadistico',
        'anexoAnalisisPruebasExternas',
        'anexosPlanesMejoramiento',
    ];

    protected $fillable = [
        'institution_id',
        'plan_estudios',
        'enfoque_metodologico',
        'estrategia_pedagogica',
        'analisis_jornada_escolar',
        'sistema_evaluacion',
        'estrategias_tareas',
        'ambientes_aprendizaje',
        'motivacion_aprendizaje',
        'plan_aula',
        'evaluacion_aula',
        'seguimiento_desempenos',
        'uso_evaluaciones_externas',
        'apoyo_pedagogico',
        'anexo_plan_estudios',
        'anexo_enfoque_pedagogico',
        'anexo_analisis_jornada',
        'anexo_sistema_evaluacion',
        'anexos_planes_aula',
        'anexos_temas_ensenanza',
        'anexo_informe_estadistico',
        'anexo_analisis_pruebas_externas',
        'anexos_planes_mejoramiento',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function anexoPlanEstudios (){
        return $this->belongsTo(Adjunto::class, 'anexo_plan_estudios');
    }
    
    public function anexoEnfoquePedagogico (){
        return $this->belongsTo(Adjunto::class, 'anexo_enfoque_pedagogico');
    }
    
    public function anexoAnalisisJornada (){
        return $this->belongsTo(Adjunto::class, 'anexo_analisis_jornada');
    }
    
    public function anexoSistemaEvaluacion (){
        return $this->belongsTo(Adjunto::class, 'anexo_sistema_evaluacion');
    }
    
    public function anexosPlanesAula (){
        return $this->belongsTo(Adjunto::class, 'anexos_planes_aula');
    }
    
    public function anexosTemasEnsenanza (){
        return $this->belongsTo(Adjunto::class, 'anexos_temas_ensenanza');
    }
    
    public function anexoInformeEstadistico (){
        return $this->belongsTo(Adjunto::class, 'anexo_informe_estadistico');
    }
    
    public function anexoAnalisisPruebasExternas (){
        return $this->belongsTo(Adjunto::class, 'anexo_analisis_pruebas_externas');
    }
    
    public function anexosPlanesMejoramiento (){
        return $this->belongsTo(Adjunto::class, 'anexos_planes_mejoramiento');
    }
}
