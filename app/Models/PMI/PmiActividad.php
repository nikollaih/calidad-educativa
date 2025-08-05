<?php

namespace App\Models\PMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiActividad extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'indicador_id',
        'id',
        'peso'
    ];

}
