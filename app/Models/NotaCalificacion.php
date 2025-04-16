<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCalificacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor',
        'descripcion',
        'indice_calificacion',
    ];

    public function autoevaluaciones()
    {
        return $this->belongsToMany(Autoevaluacion::class, 'nota_autoevaluacions', 'nota_calificacion_id', 'autoevaluacion_id')
            ->withPivot('evidencia')
            ->withTimestamps();
    }
    public function calificacion() {
        return $this->belongsTo(Calificacion::class, 'indice_calificacion', 'indice');
    }
}
