<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PamObjetivoEstrategico
 * @property bigIncrements $id
 * @property string $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @package App\Models
 */
class PamObjetivoEstrategico extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'pam_objetivos_estrategicos';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
    ];

    public function metaPlanDesarrollo()
    {
        return $this->hasMany(PamMetaPlanDesarrollo::class, 'objetivo_estrategico_id');
    }

    public function metas()
    {
        return $this->hasMany(PamMeta::class, 'objetivo_estrategico_id');
    }
}
