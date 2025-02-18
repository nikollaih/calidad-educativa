<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitucionEducativa extends Model
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
        'nombre',
        'dane',
        'direccion',
        'zona_id',
        'coordenadas',
        'acto_administrativo',
        'escuela_nueva',
        'tipo_sede_id',
    ];

    public function tipo_sede()
    {
        return $this->belongsTo(TipoSede::class, 'tipo_sede_id');
    }
    public function zona()
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }
}
