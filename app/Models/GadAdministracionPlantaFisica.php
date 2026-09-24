<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GadAdministracionPlantaFisica extends Model implements Auditable {

    use AuditingAuditable;

    protected $table = 'gad_administracion_planta_fisica';

    public $with = [
        // 'gestionAdministrativa',
        'anexoMantenimientoInfraestructura',
        'anexoDotacionRecursos',
        'historialesPei',
    ];

    public $primaryKey = 'gestion_administrativa_id';
    protected $fillable = [
        'gestion_administrativa_id',
        'mantenimiento_infraestructura',
        'anexo_mantenimiento_infraestructura',
        'dotacion_recursos_aprendizaje',
        'anexo_dotacion_recursos',
        'programas_seguiridad',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con la gestión administrativa
     */
    public function gestionAdministrativa()
    {
        return $this->belongsTo(GestionAdministrativa::class, 'gestion_administrativa_id');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }

    /**
     * Anexo de mantenimiento de infraestructura
     */
    public function anexoMantenimientoInfraestructura()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_mantenimiento_infraestructura');
    }

    /**
     * Anexo de dotación de recursos
     */
    public function anexoDotacionRecursos()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_dotacion_recursos');
    }
}