<?php

namespace Database\Seeders;

use App\Models\FactorCriticoCalificacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactorCriticoCalificacionSeeder extends Seeder
{
    public function run(): void
    {
        $catalogo = Guia34Catalogo::cargar();

        DB::transaction(function () use ($catalogo): void {
            foreach ($catalogo['componentes'] as $componente) {
                foreach ($componente['factores'] as $valorNota => $factor) {
                    FactorCriticoCalificacion::updateOrCreate(
                        [
                            'indice_calificacion' => $componente['indice'],
                            'valor_nota' => $valorNota,
                            'institucion_id' => null,
                        ],
                        ['descripcion' => $factor['descripcion']]
                    );
                }
            }
        });
    }
}
