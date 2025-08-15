<?php

namespace App\Models\PMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiIndicador extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'unidad_total',
        'unidad_parcial',
    ];

}
