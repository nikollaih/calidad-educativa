<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactorCriticoCalificacion extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'descripcion',
        'indice_calificacion',
        'institucion_id',
    ];
    public function calificacion(): BelongsTo {
        return $this->belongsTo(Calificacion::class,'indice_calificacion','indice');
    }
}
