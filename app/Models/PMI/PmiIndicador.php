<?php

namespace App\Models\PMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiIndicador extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'meta_id',
    ];
    public function actividades(){
        return $this->hasMany(PmiActividad::class, 'indicador_id');
    }
}
