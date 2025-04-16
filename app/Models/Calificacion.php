<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;
    public function grupo()
    {
        return $this->belongsTo(GrupoCalificacion::class, 'grupo_indice', 'indice');
    }
    public function notasCalificacion() {
        return $this->hasMany(NotaCalificacion::class, 'indice_calificacion', 'indice');
    }

}
