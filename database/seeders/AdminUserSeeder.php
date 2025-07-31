<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Campus;
use App\Models\Facultad;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurarse de que existe el rol de administrador
        $adminRole = Role::where('nombre_role', 'admin')->first();
        if (!$adminRole) {
            $adminRole = Role::create([
                'nombre_role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Asegurarse de que existe al menos un campus
        $campus = Campus::first();
        if (!$campus) {
            $campus = Campus::create([
                'nombre' => 'San Isidro',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Asegurarse de que existe al menos una facultad
        $facultad = Facultad::first();
        if (!$facultad) {
            $facultad = Facultad::create([
                'codigo_facultad' => 'FA001',
                'nombre' => 'Medicina',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'numero_cuenta' => '1234',
            'email' => 'admin@example.com',
            'telefono' => '12345678',
            'password' => Hash::make('holamundo123'),
            'id_role' => $adminRole->id,
            'id_campus' => $campus->id,
            'id_facultad' => $facultad->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
