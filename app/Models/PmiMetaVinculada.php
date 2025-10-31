<?php

namespace App\Models;

use App\Models\PMI\PmiIndicadorVinculado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiMetaVinculada extends Model {
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'objetivo_id',
    ];
    public function indicadores() {
        return $this->hasMany(PmiIndicadorVinculado::class, 'meta_id','id');
    }

    public function objetivo() {
        return $this->belongsTo(PmiObjetivoVinculado::class, 'objetivo_id');
    }
}
