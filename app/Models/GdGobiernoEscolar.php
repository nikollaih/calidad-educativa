<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdGobiernoEscolar extends Model
{
    protected $table = 'gd_gobierno_escolar';

    public $with = [
        'gestionDirectiva',
        'anexoGobiernoEscolar'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'gobierno_escolar',
        'anexo_gobierno_escolar'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }

    public function anexoGobiernoEscolar()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_gobierno_escolar');
    }
}