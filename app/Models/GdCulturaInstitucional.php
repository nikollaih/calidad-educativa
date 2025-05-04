<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GdCulturaInstitucional extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gd_cultura_institucional';

    public $primaryKey = 'gestion_directiva_id';

    public $with = [
'historialesPei',
        // 'gestionDirectiva',
        'anexoCulturaInstitucional',
        'anexoPoliticaBienestar'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'politica_comunicacion',
        'anexo_cultura_institucional',
        'politica_bienestar',
        'anexo_politica_bienestar',
        'inventario_buenas_practicas'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }

    public function anexoCulturaInstitucional()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_cultura_institucional');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    public function anexoPoliticaBienestar()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_politica_bienestar');
    }
}