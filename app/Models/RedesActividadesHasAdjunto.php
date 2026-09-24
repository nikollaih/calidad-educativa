<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedesActividadesHasAdjunto extends Model
{
    use HasFactory;

    protected $table = 'redes_actividades_has_adjuntos';

    protected $fillable = [
        'red_actividad_id',
        'adjunto_id',
    ];

    /**
     * Relación: Un registro de adjunto pertenece a una actividad.
     */
    public function redActividad(): BelongsTo
    {
        return $this->belongsTo(RedesActividad::class, 'red_actividad_id');
    }

    /**
     * Relación: Un registro de adjunto pertenece a un adjunto.
     */
    public function adjunto(): BelongsTo
    {
        return $this->belongsTo(Adjunto::class, 'adjunto_id');
    }
}
