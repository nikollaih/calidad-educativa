<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PamSede extends Pivot
{
    protected $table = 'pam_has_sedes';

    // Si necesitas campos adicionales en la tabla pivote
    protected $fillable = [
        'pam_id',
        'sede_id'
    ];

    // Si necesitas casts
    protected $casts = [
        'pam_id' => 'integer',
        'sede_id' => 'integer'
    ];
}