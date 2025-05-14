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
        'valor',
    ];
}
