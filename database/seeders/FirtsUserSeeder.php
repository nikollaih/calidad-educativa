<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FirtsUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $currentFirstUser = User::where("email","admin@gmail.com")->first();
        if(empty($currentFirstUser)){
            $currentFirstUser = User::create([
             'name' => 'administrador',
             'email' => 'admin@gmail.com',
             'password'=> bcrypt('password')
        ]);
        }

        $superAdmin = Role::where("name","super_admin")
            ->firstOrFail();

        // Sincronizar todos los permisos al rol super_admin
        $superAdmin->syncPermissions(Permission::all());
        // Asignar rol a un usuario por defecto
        $currentFirstUser->assignRole('super_admin');
        $currentFirstUser->save();
    }
}
