<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactorCritico extends Model
{
    use HasFactory;

    protected $fillable = [
        'autoevaluacion_id',
        'grupo_calificacion_id',
        'descripcion',
        'pmi_id',
        'valor',
    ];

    public function grupoCalificacion() {
        return $this->belongsTo(GrupoCalificacion::class, 'grupo_calificacion_id', 'id');
    }
    public function pmi(){
        return $this->belongsTo(Pmi::class, 'pmi_id', 'id');
    }
}
