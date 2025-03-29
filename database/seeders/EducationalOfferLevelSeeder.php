<?php

namespace Database\Seeders;

use App\Models\EducationalOfferLevel;
use Illuminate\Database\Seeder;

class EducationalOfferLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educationalOfferLevels = [
            // Niveles principales
            [ 'name' => 'Preescolar', 'parent_id' => null, 'category' => 'nivel'],
            [ 'name' => 'Básica', 'parent_id' => null, 'category' => 'nivel'],
            [ 'name' => 'Media', 'parent_id' => null, 'category' => 'nivel'],

            // Subniveles
            [ 'name' => 'Prejardín', 'parent_id' => 1, 'category' => 'subnivel'],
            [ 'name' => 'Jardín', 'parent_id' => 4, 'category' => 'subnivel'],
            [ 'name' => 'Transición', 'parent_id' => 4, 'category' => 'subnivel'],

            [ 'name' => 'Primaria', 'parent_id' => 2, 'category' => 'subnivel'],
            [ 'name' => 'Secundaria', 'parent_id' => 2, 'category' => 'subnivel'],

            [ 'name' => 'Grados', 'parent_id' => 3, 'category' => 'subnivel'],

            // Especialidades de Media
            [ 'name' => 'Académica', 'parent_id' => 9, 'category' => 'especialidad'],
            [ 'name' => 'Articulada', 'parent_id' => 9, 'category' => 'especialidad'],

            // Enfasis en Académica
            [ 'name' => 'Bilingüismo', 'parent_id' => 10, 'category' => 'énfasis'],
            [ 'name' => 'Educación Artística', 'parent_id' => 10, 'category' => 'énfasis'],
            [ 'name' => 'Educación Física', 'parent_id' => 10, 'category' => 'énfasis'],
            [ 'name' => 'Otros', 'parent_id' => 10, 'category' => 'énfasis'],

            // Convenios en Articulada
            [ 'name' => 'SENA', 'parent_id' => 11, 'category' => 'convenio'],
            [ 'name' => 'UQ', 'parent_id' => 11, 'category' => 'convenio'],
            [ 'name' => 'Otras Instituciones', 'parent_id' => 11, 'category' => 'convenio'],
        ];
            foreach ($educationalOfferLevels as $level) {
            EducationalOfferLevel::firstOrCreate(
                $level, // Condición para buscar
                $level // Datos a insertar/actualizar
            );
        }
    }
}
