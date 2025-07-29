<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PamAccion
 *
 * @package App\Models
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $indicador_id
 * @property string|null $nombre_responsable
 * @property string $descripcion
 * @property string $recursos
 * @property \Illuminate\Support\Carbon $fecha_inicio
 * @property \Illuminate\Support\Carbon $fecha_final
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\PamIndicador $indicador
 */
class PamAccion extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pam_acciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pam_id',
        'user_id',
        'indicador_id',
        'nombre_responsable',
        'descripcion',
        'recursos',
        'fecha_inicio',
        'fecha_final',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_final' => 'date',
    ];

    /**
     * Get the user that owns the PamAccion.
     * Define la relación de "pertenece a" con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pam() {
        return $this->belongsTo(Pam::class, 'pam_id');
    }

    /**
     * Get the indicador that owns the PamAccion.
     * Define la relación de "pertenece a" con el modelo PamIndicador.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function indicador()
    {
        return $this->belongsTo(PamIndicador::class, 'indicador_id');
    }
}
