<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PamProceso
 * @property bigIncrements $id
 * @property string $descripcion
 * @property int $componente_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\PamComponente $componente
 * @package App\Models
 */
class PamProceso extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'pam_procesos';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
        'componente_id',
    ];

    /**
     * Define la relación "pertenece a" con el modelo PamComponente.
     * Un proceso pertenece a un componente.
     */
    public function componente(): BelongsTo
    {
        return $this->belongsTo(PamComponente::class, 'componente_id');
    }

    public function subprocesos()
    {
        return $this->hasMany(PamSubproceso::class, 'proceso_id');
    }
}
