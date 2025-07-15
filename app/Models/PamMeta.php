<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PamMeta
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $descripcion
 * @property int $objetivo_estrategico_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\PamObjetivoEstrategico $objetivoEstrategico
 */
class PamMeta extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pam_metas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
        'objetivo_estrategico_id',
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
     * Get the objetivo estrategico that owns the PamMeta.
     * Define la relación de "pertenece a" con el modelo PamObjetivoEstrategico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function objetivoEstrategico()
    {
        return $this->belongsTo(PamObjetivoEstrategico::class, 'objetivo_estrategico_id');
    }

    public function indicadores()
    {
        return $this->hasMany(PamIndicador::class, 'meta_id');
    }
}
