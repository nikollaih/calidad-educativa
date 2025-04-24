<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionDirectiva extends Model
{
    protected $table = 'gestion_directiva';

    public $with = [
        'institucion'
    ];

    protected $fillable = [
        'institution_id',
        'created_at',
        'updated_at'
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institution_id');
    }
}