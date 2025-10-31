<?php

namespace App\Models\PMI;

use App\Models\PmiActividadVinculada;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PmiIndicadorVinculado extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'unidad_total',
        'unidad_parcial',
        'valor_requerido',
        'valor_obtenido',
        'meta_id',
    ];
    public function actividades():HasMany {
        return $this->hasMany(PmiActividadVinculada::class,'indicador_id','id');
    }
}
