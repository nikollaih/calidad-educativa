<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GcProgramaServicioSocial extends Model
{
    protected $table = 'gc_programa_servicio_social';

    public $with = [
        'gestionComunidad',
        'anexoProgramaServicioSocial'
    ];

    protected $fillable = [
        'gestion_comunidad_id',
        'programa_servicio_social',
        'anexo_programa_servicio_social_id'
    ];

    public function gestionComunidad()
    {
        return $this->belongsTo(GestionComunidad::class, 'gestion_comunidad_id');
    }

    public function anexoProgramaServicioSocial()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_programa_servicio_social_id');
    }
}