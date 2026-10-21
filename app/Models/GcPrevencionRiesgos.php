<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GcPrevencionRiesgos extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gc_prevencion_riesgos';

    public $with = [
'historialesPei',
        // 'gestionComunidad',
        'anexoPrevencionRiesgosFisicos',
        'anexoPrevencionRiesgosPsicosociales'
    ];
    public $primaryKey = 'gestion_comunidad_id';

    protected $fillable = [
        'gestion_comunidad_id',
        'prevencion_riesgos_fisicos',
        'anexo_prevencion_riesgos_fisicos_id',
        'prevencion_riesgos_psicosociales',
        'anexo_prevencion_riesgos_psicosociales_id'
    ];

    public function gestionComunidad()
    {
        return $this->belongsTo(GestionComunidad::class, 'gestion_comunidad_id');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    public function anexoPrevencionRiesgosFisicos()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_prevencion_riesgos_fisicos_id');
    }

    public function anexoPrevencionRiesgosPsicosociales()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_prevencion_riesgos_psicosociales_id');
    }
}
