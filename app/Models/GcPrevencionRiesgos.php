<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GcPrevencionRiesgos extends Model
{
    protected $table = 'gc_prevencion_riesgos';

    public $with = [
        'gestionComunidad',
        'anexoPrevencionRiesgosFisicos'
    ];

    protected $fillable = [
        'gestion_comunidad_id',
        'prevencion_riesgos_fisicos',
        'anexo_prevencion_riesgos_fisicos_id',
        'prevencion_riesgos_psicosociales'
    ];

    public function gestionComunidad()
    {
        return $this->belongsTo(GestionComunidad::class, 'gestion_comunidad_id');
    }

    public function anexoPrevencionRiesgosFisicos()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_prevencion_riesgos_fisicos_id');
    }
}