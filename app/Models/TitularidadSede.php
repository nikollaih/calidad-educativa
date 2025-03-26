<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitularidadSede extends Model
{
    use HasFactory;

    protected $fillable = [
        'titularity_type',
        'name',
        'sede_id',
        'support_file_id',
    ];


}
