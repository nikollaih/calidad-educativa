<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Seeder;
class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalities = [
            ["nombre" => "Armenia"],
            ["nombre" =>"Buenavista"],
            ["nombre" =>"Calarcá"],
            ["nombre" =>"Circasia"],
            ["nombre" =>"Códoba"],
            ["nombre" =>"Filandia"],
            ["nombre" =>"Génova"],
            ["nombre" =>"La Tebaida"],
            ["nombre" =>"Montenegro"],
            ["nombre" =>"Pijao"],
            ["nombre" =>"Quimbaya"],
             ["nombre" =>"Salento"],
        ];

        foreach ($municipalities as $municipality) {
            Municipio::updateOrCreate(
                ['nombre' => $municipality['nombre']], // Condición para buscar
                $municipality // Datos a insertar/actualizar
            );
        }
    }
}
