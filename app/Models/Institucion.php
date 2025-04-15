<?php

namespace App\Models;

use App\Models\Traits\RedSocialMorphRelacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory, RedSocialMorphRelacion;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'nit',
        'dane',
        'email',
        'telefono',
        'web_url',
        'nombre_rector',
        'nombre_coordinadores',
        'licencia_funcionamiento',
    ];

    public function licenciaFuncionamiento (){
        return $this->belongsTo(Adjunto::class, 'licencia_funcionamiento');
    }
    public function sedes (){
        return $this->hasMany(Sede::class,'institution_id');
    }
    public function getMorphClass() {
        return "institution";
    }
    
    public function gestionDirectiva() {
        return $this->hasOne(GestionDirectiva::class, 'institution_id');
    }

    public function gestionAcademica() {
        return $this->hasOne(GestionAcademica::class, 'institution_id');
    }

    public function gestionComunidad() {
        return $this->hasOne(GestionComunidad::class, 'institution_id');
    }

    public function gestionAdministrativa() {
        return $this->hasOne(GestionAdministrativa::class, 'institution_id');
    }
}
