<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Roles del sistema
        $roles = [
            ['name' => 'super_admin'],
            ['name' => 'administrador'],
            ['name' => 'rector'],
            ['name' => 'secretario'],
        ];
        foreach ($roles as $role) {
            Role::updateOrCreate($role,$role);
        }
    }
}
