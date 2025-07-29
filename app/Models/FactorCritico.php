<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactorCritico extends Model
{
    use HasFactory;

    protected $fillable = [
        'autoevaluacion_id',
        'calificacion_indice',
        'descripcion',
        'pmi_id',
        'valor',
    ];

    public function calificacion() {
        return $this->belongsTo(Calificacion::class, 'calificacion_indice', 'indice');
    }
    public function pmi(){
        return $this->belongsTo(Pmi::class, 'pmi_id', 'id');
    }
}
