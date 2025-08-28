<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmiActividadAvanceFiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'avance_id',
        'file_id',
    ];
}
