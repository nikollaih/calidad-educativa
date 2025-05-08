<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GdGobiernoEscolar extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gd_gobierno_escolar';

    public $primaryKey = 'gestion_directiva_id';
    public $with = [
'historialesPei',
        // 'gestionDirectiva',
        'anexoGobiernoEscolar'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'gobierno_escolar',
        'anexo_gobierno_escolar'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }

    public function anexoGobiernoEscolar()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_gobierno_escolar');
    }
    
    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
}