<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GdRelacionesEntorno extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gd_relaciones_entorno';
    public $primaryKey = 'gestion_directiva_id';

    public $with = [
'historialesPei',
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
    
    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
}