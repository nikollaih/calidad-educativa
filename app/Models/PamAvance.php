<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PamAvance extends Model {
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pam_avances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fecha_avance',
        'meta_id',
        'accion_id',
        'cantidad_ejecutada',
        'observacion',
        // 'user_id', // Si vas a asociar avances a usuarios, inclúyelo aquí
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_avance' => 'date',
    ];

    // --- Relaciones ---

    /**
     * Get the meta that owns the advance.
     */
    public function meta()
    {
        return $this->belongsTo(PamMeta::class, 'meta_id');
    }

    /**
     * Get the action that owns the advance.
     */
    public function accion()
    {
        return $this->belongsTo(PamAccion::class, 'accion_id');
    }

    /**
     * Get the attached files for the advance.
     *
     * If you create a separate table for attachments (e.g., 'pam_avance_archivos'),
     * you would define a hasMany relationship here.
     *
     * public function archivosAdjuntos()
     * {
     * return $this->hasMany(PamAvanceArchivo::class, 'pam_avance_id');
     * }
     */

    // Si quieres relacionar con el usuario que hizo el avance
    /*
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    */
}