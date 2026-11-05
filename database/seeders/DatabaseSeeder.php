<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // Reemplaza primero el catálogo y se detiene antes de tocar otros datos
        // si todavía existen autoevaluaciones o PMIs.
        $this->call(GrupoCalificacionSeeder::class);

        // Seeder de los modelos educativos
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(FirtsUserSeeder::class);
        $this->call(EducationalModelSeeder::class);
        $this->call(EducationalOfferLevelSeeder::class);
        $this->call(CalificacionSeeder::class);
        $this->call(NotaCalificacionSeeder::class);
        $this->call(FactorCriticoCalificacionSeeder::class);
        $this->call(ObjetivosConMetasSeeder::class);
        $this->call(RelacionInstitucionPeiSeeder::class);
        $this->call(MunicipalitySeeder::class);
    }
}
