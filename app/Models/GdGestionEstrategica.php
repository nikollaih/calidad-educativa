<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GdGestionEstrategica extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'gd_gestion_estrategica';

    public $primaryKey = 'gestion_directiva_id';
    public $with = [
'historialesPei',
        // 'gestionDirectiva'
    ];

    protected $fillable = [
        'gestion_directiva_id',
        'liderazgo',
        'articulacion', 
        'seguimiento'
    ];

    public function gestionDirectiva()
    {
        return $this->belongsTo(GestionDirectiva::class, 'gestion_directiva_id');
    }
    
    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
}