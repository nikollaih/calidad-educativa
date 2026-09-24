<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GaPracticasPedagogicas extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'ga_practicas_pedagogicas';

    public $with = [
'historialesPei',
        // 'gestionAcademica'
    ];
    public $primaryKey = 'gestion_academica_id';

    protected $fillable = [
        'gestion_academica_id',
        'estrategias_tareas',
        'created_at',
        'updated_at'
    ];

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    public function gestionAcademica()
    {
        return $this->belongsTo(GestionAcademica::class, 'gestion_academica_id');
    }
}