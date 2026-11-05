<?php

namespace Database\Seeders;

use App\Models\FactorCriticoCalificacion;
use App\Models\PMI\PmiMeta;
use App\Models\PMI\PmiObjetivo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ObjetivosConMetasSeeder extends Seeder
{
    public function run(): void
    {
        $catalogo = Guia34Catalogo::cargar();

        DB::transaction(function () use ($catalogo): void {
            foreach ($catalogo['componentes'] as $componente) {
                foreach ($componente['factores'] as $valorNota => $factorGuia) {
                    $factor = FactorCriticoCalificacion::query()
                        ->where('indice_calificacion', $componente['indice'])
                        ->where('valor_nota', $valorNota)
                        ->whereNull('institucion_id')
                        ->first();

                    if ($factor === null) {
                        throw new RuntimeException(sprintf(
                            'No existe el factor general %s de nivel %d para crear su objetivo y meta.',
                            $componente['indice'],
                            $valorNota
                        ));
                    }

                    $objetivo = PmiObjetivo::updateOrCreate(
                        [
                            'factor_id' => $factor->id,
                            'institucion_id' => null,
                        ],
                        ['descripcion' => $factorGuia['objetivo']]
                    );

                    PmiMeta::updateOrCreate(
                        ['objetivo_id' => $objetivo->id],
                        ['descripcion' => $factorGuia['meta']]
                    );
                }
            }
        });
    }
}
