<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GaSeguimientosAcademicos extends Model  implements Auditable {

    use AuditingAuditable;
    protected $table = 'ga_seguimientos_academicos';

    public $with = [
'historialesPei',
        // 'gestionAcademica',
        'anexoInformeEstadistico',
        'anexoAnalisisPruebasExternas',
        'anexoPlanesMejoramiento'
    ];
    public $primaryKey = 'gestion_academica_id';

    protected $fillable = [
        'gestion_academica_id',
        'seguimiento_desempenos',
        'uso_evaluaciones_externas',
        'apoyo_pedagogico',
        'anexo_informe_estadistico',
        'anexo_analisis_pruebas_externas',
        'anexos_planes_mejoramiento'
    ];

    public function gestionAcademica()
    {
        return $this->belongsTo(GestionAcademica::class, 'gestion_academica_id');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    public function anexoInformeEstadistico()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_informe_estadistico');
    }

    public function anexoAnalisisPruebasExternas()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_analisis_pruebas_externas');
    }

    public function anexoPlanesMejoramiento()
    {
        return $this->belongsTo(Adjunto::class, 'anexos_planes_mejoramiento');
    }
}