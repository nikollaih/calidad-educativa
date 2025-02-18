<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitucionEducativaSede extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'institucion_educativa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'institucion_educativa_id',
        'tipo_sede_id',
        'jornada',
        'horario_jornada',
        'nivel_educativo',
        'nivel_educativo_enfasis',
        'nivel_educativo_enfasis_acto_administrativo',
        'nivel_educativo_enfasis_acto_administrativo_anexo',
        'modelo_flexible',
        'autorizacion_validacion',
        'autorizacion_validacion_tipo',
        'anexo_autorizacion_validacion',
        'email',
        'titularidad_sede',
        'pertenencia_titularidad_sede',
        'descripcion_titularidad_sede',
        'aulas_steam',
        'no_aulas_steam',
    ];

    public function tipo_sede()
    {
        return $this->belongsTo(TipoSede::class, 'tipo_sede_id');
    }
}
