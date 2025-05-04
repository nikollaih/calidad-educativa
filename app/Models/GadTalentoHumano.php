<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class GadTalentoHumano extends Model implements Auditable {

    use AuditingAuditable;
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'gad_talento_humano';

    public $primaryKey = 'gestion_administrativa_id';
    /**
     * Relaciones que se cargarán automáticamente
     */
    public $with = [
'historialesPei',
        // 'gestionAdministrativa',
        'anexoProgramaFormacion',
        'anexoInformeAnual'
    ];

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'gestion_administrativa_id',
        'perfiles_asignacion',
        'programa_formacion_capacitacion',
        'anexo_programa_formacion',
        'pertenencia_personal',
        'evaluacion_desempeno',
        'anexo_informe_anual',
        'convivencia_manejo_conflictos',
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
     * Relación con la gestión administrativa
     */
    public function gestionAdministrativa()
    {
        return $this->belongsTo(GestionAdministrativa::class, 'gestion_administrativa_id');
    }

    /**
     * Anexo del programa de formación
     */
    public function anexoProgramaFormacion()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_programa_formacion');
    }

    public function historialesPei()
    {
        return $this->morphMany(PeiHistorial::class, 'model');
    }
    /**
     * Anexo del informe anual
     */
    public function anexoInformeAnual()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_informe_anual');
    }
}