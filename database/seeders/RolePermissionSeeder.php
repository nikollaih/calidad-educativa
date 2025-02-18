<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $superAdmin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'administrador']);
        $vendedor = Role::create(['name' => 'vendedor']);
        $contador = Role::create(['name' => 'contador']);

        $superAdmin->givePermissionTo(Permission::all());
        // $admin->givePermissionTo(['ver usuarios', 'crear usuarios', 'editar usuarios']);
        // $vendedor->givePermissionTo(['ver usuarios']);
        // $contador->givePermissionTo(['ver roles']);

        // Asignar un usuario como Super Admin
        $user = User::find(1);
        if ($user) {
            $user->assignRole('super_admin');
        }
    }
}
