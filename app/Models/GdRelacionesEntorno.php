<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdRelacionesEntorno extends Model
{
    protected $table = 'gd_relaciones_entorno';

    public $with = [
        // 'gestionDirectiva',
        'anexoAlianzasInstituciones',
        'anexoAlianzasSectorProductivo'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'relacion_familias',
        'seguimiento_egresados',
        'alianzas_instituciones',
        'anexo_alianzas_instituciones',
        'alianzas_sector_productivo',
        'anexo_alianzas_sector_productivo'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }

    public function anexoAlianzasInstituciones()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_alianzas_instituciones');
    }

    public function anexoAlianzasSectorProductivo()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_alianzas_sector_productivo');
    }
}