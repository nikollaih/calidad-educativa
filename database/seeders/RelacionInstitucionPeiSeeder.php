<?php

namespace Database\Seeders;

use App\Models\Institucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        // Si solo queremos verificar componentes individuales sin usar createEmptyPei():
        DB::transaction(function () use ($institucion) {
            // Gestion Directiva
            $gestionDirectiva = $institucion->gestionDirectiva()->firstOrCreate();
            collect(['climaEscolar', 'culturaInstitucional', 'direccionamientoEstrategico', 'gestionEstrategica', 'gobiernoEscolar', 'relacionesEntorno'])
                ->each(fn ($relacion) => $gestionDirectiva->$relacion()->firstOrCreate());

            // Gestion Académica
            $gestionAcademica = $institucion->gestionAcademica()->firstOrCreate();
            collect(['gestionAulas', 'practicasPedagogicas', 'seguimientosAcademicos', 'disenosPedagogicos'])
                ->each(fn ($relacion) => $gestionAcademica->$relacion()->firstOrCreate());

            // Gestion Comunidad
            $gestionComunidad = $institucion->gestionComunidad()->firstOrCreate();
            collect(['atencionGrupoPoblacionales', 'prevencionRiesgos', 'programasServicioSocial'])
                ->each(fn ($relacion) => $gestionComunidad->$relacion()->firstOrCreate());

            // Gestion Administrativa
            $gestionAdministrativa = $institucion->gestionAdministrativa()->firstOrCreate();
            collect(['administracionPlantaFisica', 'apoyoFinancieroContable', 'apoyoGestionAcademica', 'serviciosComplementarios', 'talentoHumano'])
                ->each(fn ($relacion) => $gestionAdministrativa->$relacion()->firstOrCreate());

            // Reseña Histórica
            $resenaHistorica = $institucion->resenaHistorica()->firstOrCreate();
            $resenaHistorica->resenaHistorica()->firstOrCreate();
        });
    }
}