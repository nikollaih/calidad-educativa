<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiObjetivoVinculado extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'descripcion',
        'factor_id',
    ];
    public function factor(){
        $this->belongsTo(FactorCritico::class, 'factor_id','id');
    }
    public function metas(){
        return $this->hasMany(PmiMetaVinculada::class, 'objetivo_id','id');
    }
}
