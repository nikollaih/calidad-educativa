<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // Seeder de los modelos educativos
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(FirtsUserSeeder::class);
        $this->call(EducationalModelSeeder::class);
        $this->call(EducationalOfferLevelSeeder::class);
        $this->call(GrupoCalificacionSeeder::class);
        $this->call(CalificacionSeeder::class);
        $this->call(NotaCalificacionSeeder::class);
        $this->call(FactorCriticoCalificacionSeeder::class);
        $this->call(RelacionInstitucionPeiSeeder::class);
        $this->call(MunicipalitySeeder::class);
    }
}
