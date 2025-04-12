<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionDirectiva extends Model {

    protected $table = 'gestion_directiva';
    public  $with = [
        'anexoGobiernoEscolar',
        'anexoCulturaInstitucional',
        'manualConvivencia',
        'anexoAlianzasInstituciones',
        'anexoAlianzasSectorProductivo',
    ];

    protected $fillable = [
        'institution_id',
        'mision',
        'vision',
        'principios_institucionales',
        'metas_institucionales',
        'politica_inclusion',
        'liderazgo',
        'articulacion',
        'seguimiento',
        'gobierno_escolar',
        'anexo_gobierno_escolar',
        'cultura',
        'anexo_cultura_institucional',
        'politica_bienestar',
        'apoyo_investigacion',
        'inventario_buenas_practicas',
        'sentido_pertenencia',
        'induccion_institucional',
        'manual_convivencia',
        'actividades_extracurriculares',
        'manejo_conflictos',
        'relacion_familias',
        'seguimiento_egresados',
        'alianzas_instituciones',
        'anexo_alianzas_instituciones',
        'alianzas_sector_productivo',
        'anexo_alianzas_sector_productivo',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    
    public function anexoGobiernoEscolar (){
        return $this->belongsTo(Adjunto::class, 'anexo_gobierno_escolar');
    }
    
    public function anexoCulturaInstitucional (){
        return $this->belongsTo(Adjunto::class, 'anexo_cultura_institucional');
    }
    
    public function manualConvivencia (){
        return $this->belongsTo(Adjunto::class, 'manual_convivencia');
    }
    
    public function anexoAlianzasInstituciones (){
        return $this->belongsTo(Adjunto::class, 'anexo_alianzas_instituciones');
    }
    
    public function anexoAlianzasSectorProductivo (){
        return $this->belongsTo(Adjunto::class, 'anexo_alianzas_sector_productivo');
    }
}
