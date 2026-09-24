<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GaDisenosPedagogicos extends Model implements Auditable {

    use AuditingAuditable;
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'ga_disenos_pedagogicos';

    public $primaryKey = 'gestion_academica_id';
    /**
     * Relaciones que se cargarán automáticamente
     */
    public $with = [
'historialesPei',
        // 'gestionAcademica',
        'anexoPlanEstudios',
        'anexoEnfoquePedagogico',
        'anexoAnalisisJornada',
        'anexoSistemaEvaluacion'
    ];

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'gestion_academica_id',
        'plan_estudios',
        'enfoque_metodologico',
        'estrategia_pedagogica',
        'analisis_jornada_escolar',
        'sistema_evaluacion',
        'anexo_plan_estudios',
        'anexo_enfoque_pedagogico',
        'anexo_analisis_jornada',
        'anexo_sistema_evaluacion',
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
     * Relación con la gestión académica
     */
    public function gestionAcademica()
    {
        return $this->belongsTo(GestionAcademica::class, 'gestion_academica_id');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    /**
     * Anexo del plan de estudios
     */
    public function anexoPlanEstudios()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_plan_estudios');
    }

    /**
     * Anexo del enfoque pedagógico
     */
    public function anexoEnfoquePedagogico()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_enfoque_pedagogico');
    }

    /**
     * Anexo del análisis de jornada
     */
    public function anexoAnalisisJornada()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_analisis_jornada');
    }

    /**
     * Anexo del sistema de evaluación
     */
    public function anexoSistemaEvaluacion()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_sistema_evaluacion');
    }
}