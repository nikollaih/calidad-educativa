<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiMetaVinculada extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'objetivo_id',
        'unidad_medida',
        'valor_requerido',
    ];
    public function actividades(){
        return $this->hasMany(PmiActividadVinculada::class, 'meta_id','id');
    }
}
