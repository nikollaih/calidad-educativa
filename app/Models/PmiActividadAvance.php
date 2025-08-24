<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiActividadAvance extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_avance',
        'porcentaje_ejecutado',
        'suma_al_indicador',
        'descripcion',
        'pmi_id',
        'actividad_id',
    ];
}
