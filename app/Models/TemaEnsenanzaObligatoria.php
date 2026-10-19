<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TemaEnsenanzaObligatoria extends Model
{
    use HasFactory;

    protected $table = 'temas_ensenanza_obligatoria';

    protected $fillable = ['nombre'];

    public function proyectosTransversales(): BelongsToMany
    {
        return $this->belongsToMany(
            ProyectosTransversal::class,
            'proyecto_transversal_tema_ensenanza_obligatoria',
            'tema_ensenanza_obligatoria_id',
            'proyecto_transversal_id'
        )->withTimestamps();
    }
}
