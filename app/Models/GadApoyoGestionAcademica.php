<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GadApoyoGestionAcademica extends Model
{

    protected $table = 'gad_apoyo_gestion_academica';

    public $with = [
        // 'gestionAdministrativa',
        'anexoActoAdministrativo'
    ];

    protected $fillable = [
        'gestion_administrativa_id',
        'proceso_matricula',
        'anexo_acto_administrativo_proceso_matricula',
        'sistema_informacion_academica',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con la gestión administrativa
     */
    public function gestionAdministrativa()
    {
        return $this->belongsTo(GestionAdministrativa::class, 'gestion_administrativa_id');
    }

    /**
     * Anexo del acto administrativo del proceso de matrícula
     */
    public function anexoActoAdministrativo()
    {
        return $this->belongsTo(Adjunto::class, 'anexo_acto_administrativo_proceso_matricula');
    }
}