<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiActividadVinculada extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'peso',
        'responsables',
        'recursos',
        'fecha_inicio',
        'fecha_fin',
        'meta_id',
    ];
}
