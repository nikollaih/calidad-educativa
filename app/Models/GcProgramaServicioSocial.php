<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GcProgramaServicioSocial extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gc_programa_servicio_social';

    public $with = [
'historialesPei',
        // 'gestionComunidad',
        'anexoProgramaServicioSocial'
    ];
    public $primaryKey = 'gestion_comunidad_id';

    protected $fillable = [
        'gestion_comunidad_id',
        'programa_servicio_social',
        'anexo_programa_servicio_social_id'
    ];

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    public function gestionComunidad()
    {
        return $this->belongsTo(GestionComunidad::class, 'gestion_comunidad_id');
    }

    public function anexoProgramaServicioSocial()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_programa_servicio_social_id');
    }
}