<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdDireccionamientoEstrategico extends Model
{
    protected $table = 'gd_direccionamiento_estrategico';

    public $with = [
        // 'gestionDirectiva',
        'anexoPoliticaInclusion'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'mision',
        'vision',
        'principios_institucionales',
        'metas_institucionales',
        'politica_inclusion',
        'anexo_politica_inclusion'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }

    public function anexoPoliticaInclusion()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_politica_inclusion');
    }
}