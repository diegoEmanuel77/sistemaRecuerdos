<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'administrador']);
        $clientRole = Role::create(['name' => 'cliente']);

        
        $admin = User::create([
            'name' => 'Diego Chavez',
            'email' => 'emmanuelz7u7@gmail.com',
            'password' => bcrypt('diego'),
        ]);

       
        $admin->assignRole($adminRole);
    }
}
