<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pmi extends Model
{
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

    public function autoevaluacion(){
        return $this->belongsTo(Autoevaluacion::class, 'autoevaluacion_id');
    }
    public function factoresCriticos(){
        return $this->hasMany(FactorCritico::class, 'pmi_id');
    }
}
