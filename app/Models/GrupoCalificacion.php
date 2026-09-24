<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoCalificacion extends Model
{
    use HasFactory;

    // Relación con el padre
    public function padre()
    {
        return $this->belongsTo(GrupoCalificacion::class, 'padre_id');
    }

    // Relación con los hijos (subgrupos)
    public function hijos()
    {
        return $this->hasMany(GrupoCalificacion::class, 'padre_id');
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'grupo_indice', 'indice');
    }
    public function factoresCriticos()
    {
        return $this->hasMany(FactorCritico::class, 'grupo_calificacion_id', 'id');
    }

}
