<?php

namespace App\Models;

use App\Models\PMI\PmiComentarioFactor\PmiComentarioFactor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pmi extends Model {
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'descripcion',
        'anio_inicio',
        'anio_fin',
        'autoevaluacion_id',
    ];

    public function autoevaluacion() {
        return $this->belongsTo(Autoevaluacion::class, 'autoevaluacion_id');
    }
    public function factoresCriticos() {
        return $this->hasMany(FactorCritico::class, 'pmi_id');
    }
    public function objetivosVinculados() {
        return $this->hasManyThrough(
            PmiObjetivoVinculado::class, // Modelo destino
            FactorCritico::class,        // Modelo intermedio
            'pmi_id',    // Foreign key en factoresCriticos que apunta al PMI
            'factor_id', // Foreign key en objetivosVinculados que apunta al factor
            'id',        // Primary key de PMI
            'id'         // Primary key de FactorCritico
        );
    }
    public function institucion() {
        return $this->hasOneThrough(
            Institucion::class,       // Modelo destino
            Autoevaluacion::class,    // Modelo intermedio
            'id',                     // Foreign key en Autoevaluacion (clave local referenciada en PMI)
            'id',                     // Foreign key en Institucion
            'autoevaluacion_id',      // Foreign key en PMI que apunta a Autoevaluacion
            'institucion_id'          // Foreign key en Autoevaluacion que apunta a Institucion
        );
    }
    public function comentarios() {
        return $this->hasMany(PmiComentarioFactor::class,'pmi_id');
    }
}
