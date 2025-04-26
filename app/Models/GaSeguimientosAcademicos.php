<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaSeguimientosAcademicos extends Model 
{
    protected $table = 'ga_seguimientos_academicos';

    public $with = [
        // 'gestionAcademica',
        'anexoInformeEstadistico',
        'anexoAnalisisPruebasExternas',
        'anexoPlanesMejoramiento'
    ];

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