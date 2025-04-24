<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaGestionAulas extends Model
{
    protected $table = 'ga_gestion_aulas';

    public $with = [
        'gestionAcademica',
        'anexoPlanesAula',
        'anexoTemasEnsenanza'
    ];

    protected $fillable = [
        'gestion_academica_id',
        'ambientes_aprendizaje',
        'motivacion_aprendizaje',
        'plan_aula',
        'evaluacion_aula',
        'anexos_planes_aula',
        'anexos_temas_ensenanza'
    ];

    public function gestionAcademica()
    {
        return $this->belongsTo(GestionAcademica::class, 'gestion_academica_id');
    }

    public function anexoPlanesAula()
    {
        return $this->belongsTo(Adjunto::class, 'anexos_planes_aula');
    }

    public function anexoTemasEnsenanza()
    {
        return $this->belongsTo(Adjunto::class, 'anexos_temas_ensenanza');
    }
}