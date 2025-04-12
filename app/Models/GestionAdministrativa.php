<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionAdministrativa extends Model {

    protected $table = 'gestion_administrativa';

    protected $fillable = [
        'institution_id',
        'proceso_matricula',
        'anexo_proceso_matricula',
        'sistema_informacion_academica',
        'mantenimiento_infraestructura',
        'anexo_mantenimiento_infraestructura',
        'dotacion_recursos_aprendizaje',
        'anexo_dotacion_recursos',
        'programas_seguridad',
        'estrategias_acceso_permanencia',
        'perfiles_asignacion',
        'programa_formacion_capacitacion',
        'anexo_programa_formacion',
        'pertenencia_personal',
        'evaluacion_desempeno',
        'convivencia_manejo_conflictos',
        'presupuesto_fse',
        'anexo_presupuesto_fse',
        'contabilidad',
        'contratacion',
        'control_fiscal',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
