<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PamComponente
 * * @property bigIncrements $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * * @package App\Models
 */
class PamComponente extends Model
{
    // Uso de traits para funcionalidades adicionales
    use HasFactory; // Trait para la integración con las factorías de modelos
    use SoftDeletes; // Trait para habilitar el borrado lógico (soft delete)

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'pam_componentes';

    protected $with = ['componente'];

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'componente_id',
    ];

    public function procesos() {
        return $this->hasMany(PamProceso::class, 'componente_id');
    }

    public function componente() {
        return $this->belongsTo(Componente::class, 'componente_id');
    }

}
