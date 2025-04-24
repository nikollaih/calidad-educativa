<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GadServicesComplementarios extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'gad_services_complementarios';

    /**
     * Relaciones que se cargarán automáticamente
     */
    public $with = [
        'gestionAdministrativa'
    ];

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'gestion_administrativa_id',
        'estrategias_acceso_permanencia',
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
}