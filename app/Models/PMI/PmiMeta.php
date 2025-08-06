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
        'objetivo_id',
    ];

    public function actividades(){
        return $this->hasMany(PmiActividad::class, 'meta_id');
    }
}
