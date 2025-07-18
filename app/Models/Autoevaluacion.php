<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoevaluacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'institucion_id',
        'anio_vigencia',
        'alias_estado',
    ];

    public function notas()
    {
        return $this->belongsToMany(NotaCalificacion::class, 'nota_autoevaluacions', 'autoevaluacion_id', 'nota_calificacion_id')
            ->withPivot('evidencia')
            ->withTimestamps();
    }
    public function pmi(){
        return $this->hasOne(Pmi::class, 'autoevaluacion_id');
    }
    public function institucion(){
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
    public function factoresCriticos() {
        return $this->hasMany(FactorCritico::class, 'autoevaluacion_id');
    }
}
