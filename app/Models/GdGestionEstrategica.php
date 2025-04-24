<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdGestionEstrategica extends Model
{
    protected $table = 'gd_gestion_estrategica';

    public $with = [
        'gestionDirectiva'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'liderazgo',
        'articulacion', 
        'seguimiento'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }
}