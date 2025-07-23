<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase del modelo PamAvanceArchivo
 */
class PamAvanceArchivo extends Model {
    use HasFactory;

    protected $table = 'pam_avance_archivos';

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pam_avance_id',
        'nombre_original',
        'ruta_archivo',
        'tipo_mime',
        'tamano',
    ];

    /**
     * Define la relación inversa: un Archivo Adjunto pertenece a un Avance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avance() {
        return $this->belongsTo(PamAvance::class, 'pam_avance_id');
    }
}
