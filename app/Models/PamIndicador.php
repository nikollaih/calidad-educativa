<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PamIndicador
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $descripcion
 * @property int $meta_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\PamMeta $meta
 */
class PamIndicador extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pam_indicadores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
        'meta_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // No hay atributos que necesiten un casting especial por ahora.
    ];

    /**
     * Get the meta that owns the PamIndicador.
     * Define la relación de "pertenece a" con el modelo PamMeta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meta()
    {
        return $this->belongsTo(PamMeta::class, 'meta_id');
    }

    public function accion()
    {
        return $this->hasMany(PamAccion::class, 'indicador_id');
    }

    public function accionHasOne()
    {
        return $this->hasOne(PamAccion::class, 'indicador_id');
    }
}
