<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GadServicesComplementarios extends Model implements Auditable {

    use AuditingAuditable;
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'gad_servicios_complementarios';

    public $primaryKey = 'gestion_administrativa_id';
    /**
     * Relaciones que se cargarán automáticamente
     */
    public $with = [
'historialesPei',
        // 'gestionAdministrativa'
    ];

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'gestion_administrativa_id',
        'estrategias_acceso_permanencia',
        'created_at',
        'updated_at'
    ];

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    /**
     * Conversiones de tipos
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con la gestión administrativa
     */
    public function gestionAdministrativa()
    {
        return $this->belongsTo(GestionAdministrativa::class, 'gestion_administrativa_id');
    }
}