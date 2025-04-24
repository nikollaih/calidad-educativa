<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaPracticasPedagogicas extends Model
{
    protected $table = 'ga_practicas_pedagogicas';

    public $with = [
        'gestionAcademica'
    ];

    protected $fillable = [
        'gestion_academica_id',
        'estrategias_tareas',
        'created_at',
        'updated_at'
    ];

    public function gestionAcademica()
    {
        return $this->belongsTo(GestionAcademica::class, 'gestion_academica_id');
    }
}