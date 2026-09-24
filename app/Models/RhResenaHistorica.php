<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class RhResenaHistorica extends Model implements Auditable {

    use AuditingAuditable;
    protected $table = 'rh_resena_historica';

    public $with = [
        'historialesPei',
    ];
    public $primaryKey = 'resena_historica_id';

    protected $fillable = [
        'resena_historica_id',
        'resena_historica',
    ];

    public function resenaHistorica()
    {
        return $this->belongsTo(ResenaHistorica::class, 'resena_historica_id');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
}