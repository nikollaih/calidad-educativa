<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PamSubproceso
 * @property bigIncrements $id
 * @property string $descripcion
 * @property int $proceso_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\PamProceso $proceso
 * @package App\Models
 */
class PamSubproceso extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'pam_subprocesos';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
        'proceso_id',
    ];

    /**
     * Define la relación "pertenece a" con el modelo PamProceso.
     * Un subproceso pertenece a un proceso.
     */
    public function proceso(): BelongsTo
    {
        return $this->belongsTo(PamProceso::class, 'proceso_id');
    }

    public function metasPlanDesarrollo()
    {
        return $this->hasMany(PamMetaPlanDesarrollo::class, 'subproceso_id');
    }
}
