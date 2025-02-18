<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $superAdmin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'administrador']);
        $vendedor = Role::create(['name' => 'rector']);
        $contador = Role::create(['name' => 'secretario']);

        // Crear permisos
        // Permission::create(['name' => 'crear usuarios']);
        // Permission::create(['name' => 'editar usuarios']);
        // Permission::create(['name' => 'eliminar usuarios']);
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
        
        // Asignar permisos a los roles
        $superAdmin->givePermissionTo(Permission::all());
        // $admin->givePermissionTo(['crear usuarios', 'editar usuarios']);
        
        // Asignar rol a un usuario por defecto
        $user = User::find(1); // Cambiar por un usuario existente
        $user->assignRole('super_admin');
    }
}
