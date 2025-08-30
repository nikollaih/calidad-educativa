<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyectoIntegrante extends Model
{
    use HasFactory;

    protected $table = 'proyecto_integrantes';

    protected $fillable = [
        'proyecto_transversal_id',
        'nombre',
        'telefono',
        'correo',
        'rol',
    ];

    /**
     * Relación: Un integrante pertenece a un proyecto transversal.
     */
    public function proyectoTransversal(): BelongsTo
    {
        return $this->belongsTo(ProyectosTransversal::class, 'proyecto_transversal_id');
    }
}
