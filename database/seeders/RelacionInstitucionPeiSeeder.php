<?php

namespace Database\Seeders;

use App\Models\Institucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelacionInstitucionPeiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instituciones = Institucion::all();

        foreach ($instituciones as $institucion) {
            $this->verificarYCrearRelaciones($institucion);
        }
    }

    /**
     * Verifica y crea las relaciones PEI faltantes para una institución
     */
    private function verificarYCrearRelaciones(Institucion $institucion): void
    {
        // Verificar y crear cada componente del PEI si no existe
        // if (!$institucion->gestionDirectiva) {
        //     $this->command->info("Creando gestión directiva para institución ID: {$institucion->id}");
        //     $institucion->createEmptyPei();
        //     return; // El método createEmptyPei() ya crea todas las relaciones
        // }

        // Si solo queremos verificar componentes individuales sin usar createEmptyPei():
        if (!$institucion->gestionDirectiva) {
            $gestionDirectiva = $institucion->gestionDirectiva()->create();
            $gestionDirectiva->climaEscolar()->create();
            $gestionDirectiva->culturaInstitucional()->create();
            $gestionDirectiva->direccionamientoEstrategico()->create();
            $gestionDirectiva->gestionEstrategica()->create();
            $gestionDirectiva->gobiernoEscolar()->create();
            $gestionDirectiva->relacionesEntorno()->create();
        }
        if (!$institucion->gestionAcademica) {
            $gestionAcademica = $institucion->gestionAcademica()->create();
            $gestionAcademica->gestionAulas()->create();
            $gestionAcademica->practicasPedagogicas()->create();
            $gestionAcademica->seguimientosAcademicos()->create();
            $gestionAcademica->disenosPedagogicos()->create();
        }
        if (!$institucion->gestionComunidad) {
            $gestionComunidad = $institucion->gestionComunidad()->create();
            $gestionComunidad->atencionGrupoPoblacionales()->create();
            $gestionComunidad->prevencionRiesgos()->create();
            $gestionComunidad->programasServicioSocial()->create();
        }
        if (!$institucion->gestionAdministrativa) {
            $gestionAdministrativa = $institucion->gestionAdministrativa()->create();
            $gestionAdministrativa->administracionPlantaFisica()->create();
            $gestionAdministrativa->apoyoFinancieroContable()->create();
            $gestionAdministrativa->apoyoGestionAcademica()->create();
            $gestionAdministrativa->serviciosComplementarios()->create();
            $gestionAdministrativa->talentoHumano()->create();
        }
        if (!$institucion->resenaHistorica) {
            $resenaHistorica = $institucion->resenaHistorica()->create();
            $resenaHistorica->resenaHistorica()->create();
        }
    }
}