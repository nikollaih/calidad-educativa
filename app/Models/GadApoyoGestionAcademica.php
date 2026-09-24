<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GadApoyoGestionAcademica extends Model implements Auditable {

    use AuditingAuditable;

    protected $table = 'gad_apoyo_gestion_academica';

    public $primaryKey = 'gestion_administrativa_id';
    public $with = [
'historialesPei',
        // 'gestionAdministrativa',
        'anexoActoAdministrativo'
    ];

    protected $fillable = [
        'gestion_administrativa_id',
        'proceso_matricula',
        'anexo_acto_administrativo_proceso_matricula',
        'sistema_informacion_academica',
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

    /**
     * Anexo del acto administrativo del proceso de matrícula
     */
    public function anexoActoAdministrativo()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_acto_administrativo_proceso_matricula');
    }
    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
}