<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdCulturaInstitucional extends Model
{
    protected $table = 'gd_cultura_institucional';

    public $with = [
        // 'gestionDirectiva',
        'anexoCulturaInstitucional',
        'anexoPoliticaBienestar'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'politica_comunicacion',
        'anexo_cultura_institucional',
        'politica_bienestar',
        'anexo_politica_bienestar',
        'inventario_buenas_practicas'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }

    public function anexoCulturaInstitucional()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_cultura_institucional');
    }

    public function anexoPoliticaBienestar()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_politica_bienestar');
    }
}