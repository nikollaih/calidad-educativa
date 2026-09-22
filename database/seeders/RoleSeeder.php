<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seguridad\Permission\Permission;
use App\Models\Seguridad\Role\Role;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Roles del sistema
        $roles = [
            [
                'name' => 'super_admin'
            ],
            [
                'name' => 'administrador'
            ],
            [
                'name' => 'rector'
            ],
            [
                'name' => 'Docente',
                'permissions' => [
                    's-institucion-pertenecer_una'
                ]
            ],
            [
                'name' => 'Administrativo',
                'permissions' => [
                    's-institucion-pertenecer_una'
                ]
            ],
            [
                'name' => 'secretario'
            ],
            [
                'name' => 'secretaria_educacion'
            ],
        ];

        foreach ($roles as $roleData) {
            // Crear o actualizar el rol solo con el nombre
            $role = Role::updateOrCreate(
                ['name' => $roleData['name']],
                ['name' => $roleData['name']]
            );

            // Sincronizar permisos si existen
            if (isset($roleData['permissions']) && !empty($roleData['permissions'])) {
                $permissions = Permission::whereIn('name', $roleData['permissions'])->get();
                $role->syncPermissions($permissions);
            }
        }
    }
}
