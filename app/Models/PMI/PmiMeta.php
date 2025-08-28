<?php

namespace App\Models\PMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiMeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'objetivo_id',
        'indicador_id'
    ];

    public function actividades(){
        return $this->hasMany(PmiActividad::class, 'meta_id');
    }
}
