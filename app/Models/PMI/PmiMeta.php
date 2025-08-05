<?php

namespace App\Models\PMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiMeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'unidad_medida',
        'valor_requerido',
    ];

    public function indicadores(){
        return $this->hasMany(PmiIndicador::class, 'meta_id');
    }
}
