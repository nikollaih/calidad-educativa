<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GadApoyoFinancieroContable extends Model implements Auditable {

    use AuditingAuditable;

    protected $table = 'gad_apoyo_financiero_contable';

    public $primaryKey = 'gestion_administrativa_id';
    public $with = [
'historialesPei',
        // 'gestionAdministrativa',
        'anexoPresupuestoFse',
        'anexoManualContratacion'
    ];

    protected $fillable = [
        'gestion_administrativa_id',
        'presupuesto_fse',
        'anexo_presupuesto_fse',
        'contabilidad',
        'contratacion',
        'anexo_manual_contratacion',
        'control_fiscal',
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
     * Anexo del presupuesto FSE
     */
    public function anexoPresupuestoFse()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_presupuesto_fse');
    }

    /**
     * Anexo del manual de contratación
     */
    public function anexoManualContratacion()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_manual_contratacion');
    }
}