<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationalModel; // Asegúrate de importar el modelo

class EducationalModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            ["name" => "Aceleración del aprendizaje"],
            ["name" => "Pensar"],
            ["name" => "Caminar"],
            ["name" => "Post Primaria"]
        ];

        foreach ($models as $model) {
            EducationalModel::updateOrCreate(
                ['name' => $model['name']], // Condición para buscar
                $model // Datos a insertar/actualizar
            );
        }
    }
}
