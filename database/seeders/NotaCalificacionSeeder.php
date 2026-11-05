<?php

namespace Database\Seeders;

use App\Models\NotaCalificacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotaCalificacionSeeder extends Seeder
{
    public function run(): void
    {
        $catalogo = Guia34Catalogo::cargar();

        DB::transaction(function () use ($catalogo): void {
            foreach ($catalogo['componentes'] as $componente) {
                foreach ($componente['notas'] as $valor => $descripcion) {
                    NotaCalificacion::updateOrCreate(
                        [
                            'indice_calificacion' => $componente['indice'],
                            'valor' => $valor,
                        ],
                        ['descripcion' => $descripcion]
                    );
                }
            }
        });
    }
}
