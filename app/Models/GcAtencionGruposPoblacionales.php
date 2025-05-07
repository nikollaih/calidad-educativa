<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GcAtencionGruposPoblacionales extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gc_atencion_grupos_poblacionales';

    public $with = [
'historialesPei',
        // 'gestionComunidad',
        'anexoProyectoEscuelaPadres'
    ];

    public $primaryKey = 'gestion_comunidad_id';
    protected $fillable = [
        'gestion_comunidad_id',
        'atencion_grupo_vulnerabilidad',
        'necesidades_expectativas_estudiantes',
        'proyectos_vida',
        'escuela_padres',
        'oferta_servicios_comunidad',
        'anexo_proyecto_escuela_padres_id'
    ];

    public function gestionComunidad()
    {
        return $this->belongsTo(GestionComunidad::class, 'gestion_comunidad_id');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    public function anexoProyectoEscuelaPadres()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_proyecto_escuela_padres_id');
    }
}