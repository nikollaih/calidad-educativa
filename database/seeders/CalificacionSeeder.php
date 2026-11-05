<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalificacionSeeder extends Seeder
{
    public function run(): void
    {
        $catalogo = Guia34Catalogo::cargar();

        DB::transaction(function () use ($catalogo): void {
            foreach ($catalogo['componentes'] as $componente) {
                Calificacion::updateOrCreate(
                    ['indice' => $componente['indice']],
                    [
                        'nombre' => $componente['nombre'],
                        'grupo_indice' => $componente['grupo_indice'],
                    ]
                );
            }
        });
    }
}
