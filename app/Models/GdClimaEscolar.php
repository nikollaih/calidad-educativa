<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GdClimaEscolar extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gd_clima_escolar';

    public $with = [
'historialesPei',
        // 'gestionDirectiva',
        'anexoProgramaInstitucionalInduccion',
        'manualConvivencia'
    ];

    public $primaryKey = 'gestion_directiva_id';

    protected $fillable = [
        'gestion_directiva_id',
        'sentido_pertenencia',
        'induccion_institucional',
        'anexo_programa_institucional_induccion',
        'manual_convivencia',
        'actividades_extracurriculares',
        'manejo_conflictos'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    public function anexoProgramaInstitucionalInduccion()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_programa_institucional_induccion');
    }

    public function manualConvivencia()
    {
        return $this->belongsTo(Adjunto::class, 'manual_convivencia');
    }
}