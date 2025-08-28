<?php

namespace App\Models;

use App\Models\PMI\PmiIndicador;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiMetaVinculada extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'objetivo_id',
        'indicador_id',
        'valor_requerido',
    ];
    public function actividades(){
        return $this->hasMany(PmiActividadVinculada::class, 'meta_id','id');
    }
    public function indicadorInfo(){
        return $this->belongsTo(PmiIndicador::class, 'indicador_id');
    }
}
