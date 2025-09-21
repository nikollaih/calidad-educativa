<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Crear permisos
        $permissions = [
            ['name'=>'hr-usuario-ver'],
            ['name'=>'hr-usuario-crear'],
            ['name'=>'hr-usuario-editar'],
            ['name'=>'hr-usuario-eliminar'],
            ['name'=>'s-role-ver'],
            ['name'=>'s-role-crear'],
            ['name'=>'s-role-editar'],
            ['name'=>'s-role-eliminar'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
