<?php

namespace App\Models;

use App\Models\Traits\RedSocialMorphRelacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Institucion extends Model {
    use HasFactory, RedSocialMorphRelacion;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'nombre',
        'rector_id',
        'nit',
        'dane',
        'email',
        'municipio_id',
        'telefono',
        'web_url',
        'nombre_rector',
        'nombre_coordinadores',
        'licencia_funcionamiento',
    ];

    public function licenciaFuncionamiento () {
        return $this->belongsTo(Adjunto::class, 'licencia_funcionamiento');
    }
    public function sedes () {
        return $this->hasMany(Sede::class,'institution_id');
    }
    public function rector () {
        return $this->belongsTo(User::class,'rector_id');
    }
    public function autoevaluacions() {
        return $this->hasMany(Autoevaluacion::class, 'institucion_id');
    }
    public function autoevaluaciones() {
        return $this->hasMany(Autoevaluacion::class, 'institucion_id');
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

    public function resenaHistorica() {
        return $this->hasOne(ResenaHistorica::class, 'institution_id');
    }


    /**
     * Crea una estructura PEI vacía para la institución
     */
    public function createEmptyPei(): void {
        // Usar transacción para asegurar integridad de datos
        DB::transaction(function () {
            // Crear gestión directiva con sus relaciones
            $gestionDirectiva = $this->gestionDirectiva()->create();
            $gestionDirectiva->climaEscolar()->create();
            $gestionDirectiva->culturaInstitucional()->create();
            $gestionDirectiva->direccionamientoEstrategico()->create();
            $gestionDirectiva->gestionEstrategica()->create();
            $gestionDirectiva->gobiernoEscolar()->create();
            $gestionDirectiva->relacionesEntorno()->create();

            // Crear gestión académica con sus relaciones
            $gestionAcademica = $this->gestionAcademica()->create();
            $gestionAcademica->gestionAulas()->create();
            $gestionAcademica->practicasPedagogicas()->create();
            $gestionAcademica->seguimientosAcademicos()->create();
            $gestionAcademica->disenosPedagogicos()->create();

            // Crear gestión de comunidad con sus relaciones
            $gestionComunidad = $this->gestionComunidad()->create();
            $gestionComunidad->atencionGrupoPoblacionales()->create();
            $gestionComunidad->prevencionRiesgos()->create();
            $gestionComunidad->programasServicioSocial()->create();

            // Crear gestión administrativa con sus relaciones
            $gestionAdministrativa = $this->gestionAdministrativa()->create();
            $gestionAdministrativa->administracionPlantaFisica()->create();
            $gestionAdministrativa->apoyoFinancieroContable()->create();
            $gestionAdministrativa->apoyoGestionAcademica()->create();
            $gestionAdministrativa->serviciosComplementarios()->create();
            $gestionAdministrativa->talentoHumano()->create();

            // Crear resena historica
            $resenaHistorica = $this->resenaHistorica()->create();
            $resenaHistorica->resenaHistorica()->create();
        });
    }

    /**
     * Método estático para crear PEI desde ID de institución
     */
    public static function createEmptyPeiFor(int $institucionId): void {
        $institution = static::findOrFail($institucionId);
        $institution->createEmptyPei();
    }
}
