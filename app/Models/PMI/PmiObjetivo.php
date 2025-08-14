<?php

namespace App\Models\PMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiObjetivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
    ];
    public function metas(){
        return $this->hasMany(PmiMeta::class, 'objetivo_id');
    }
}
