<?php

namespace App\Models;

use App\Models\PMI\PmiIndicadorVinculado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiActividadVinculada extends Model {
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'peso',
        'accumulated',
        'responsables',
        'instrumentos_recoleccion',
        'recursos',
        'fecha_inicio',
        'fecha_fin',
        'indicador_id',
        'afecta_indicador',
        'max_suma_indicador',
        'indicador_acumulado'
    ];
    protected $casts = [
        'afecta_indicador' => 'boolean',
    ];
    public function indicador() {
        return $this->belongsTo(PmiIndicadorVinculado::class,'indicador_id');
    }
}
