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
    public function actividad(){
        return $this->belongsTo(PmiActividadVinculada::class, 'actividad_id');
    }
    public function adjuntos()
    {
        return $this->belongsToMany(
            Adjunto::class,
            'pmi_actividad_avance_files', // nombre de la tabla pivote
            'avance_id',                  // clave foránea en la pivote hacia PmiActividadAvance
            'file_id'                     // clave foránea en la pivote hacia Adjunto
        )->withTimestamps();
    }
}
