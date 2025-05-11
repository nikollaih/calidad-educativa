<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ResenaHistorica extends Model implements Auditable {

    use AuditingAuditable;
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'resena_historica';

    /**
     * Relaciones que se cargarán automáticamente
     */
    public $with = [
        'institucion',
        'resenaHistorica',
    ];

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'institution_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Conversiones de tipos
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con la institución
     */
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institution_id');
    }
    
    /**
     * Relación con resena hsitorica
     */
    public function resenaHistorica()
    {
        return $this->hasOne(RhResenaHistorica::class, 'resena_historica_id');
    }

}