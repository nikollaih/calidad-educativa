<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GestionAdministrativa extends Model  implements Auditable {

    use AuditingAuditable;

    protected $table = 'gestion_administrativa';

    // Relaciones a cargar automáticamente
    public $with = [
        'institucion',
        'administracionPlantaFisica',
        'apoyoFinancieroContable',
        'apoyoGestionAcademica',
        'serviciosComplementarios',
        'talentoHumano'
    ];

    // Campos asignables masivamente
    protected $fillable = [
        'institution_id',
        'created_at',
        'updated_at'
    ];

    // Campos que deben ser tratados como fechas
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con la institución
     */
    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
    
    /**
     * Relación con GadAdministracionPlantaFisica (1 a 1)
     */
    public function administracionPlantaFisica()
    {
        return $this->hasOne(GadAdministracionPlantaFisica::class, 'gestion_administrativa_id');
    }

    /**
     * Relación con GadApoyoFinancieroContable (1 a 1)
     */
    public function apoyoFinancieroContable()
    {
        return $this->hasOne(GadApoyoFinancieroContable::class, 'gestion_administrativa_id');
    }

    /**
     * Relación con GadApoyoGestionAcademica (1 a 1)
     */
    public function apoyoGestionAcademica()
    {
        return $this->hasOne(GadApoyoGestionAcademica::class, 'gestion_administrativa_id');
    }

    /**
     * Relación con GadServicesComplementarios (1 a 1)
     */
    public function serviciosComplementarios()
    {
        return $this->hasOne(GadServicesComplementarios::class, 'gestion_administrativa_id');
    }

    /**
     * Relación con GadTalentolHumano (1 a 1)
     */
    public function talentoHumano()
    {
        return $this->hasOne(GadTalentoHumano::class, 'gestion_administrativa_id');
    }
}