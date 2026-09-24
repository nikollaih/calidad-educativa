<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GdDireccionamientoEstrategico extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gd_direccionamiento_estrategico';

    public $primaryKey = 'gestion_directiva_id';
    public $with = [
'historialesPei',
        // 'gestionDirectiva',
        'anexoPoliticaInclusion'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'mision',
        'vision',
        'principios_institucionales',
        'metas_institucionales',
        'politica_inclusion',
        'anexo_politica_inclusion'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    public function anexoPoliticaInclusion()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_politica_inclusion');
    }
}