<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

class ContratacionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el rol de contratación
        $contratacionRole = Roles::where('name', 'contratacion')->first();
        
        if (!$contratacionRole) {
            $this->command->error('Rol "contratacion" no encontrado. Ejecuta primero el RoleSeeder.');
            return;
        }

        // Crear usuarios de contratación de prueba
        $contratacionUsers = [
            [
                'name' => 'María Elena González',
                'email' => 'contratacion@municipio.gov.co',
                'password' => Hash::make('contratacion123'),
                'cedula' => '98765432',
                'telefono' => '3201234567',
                'direccion' => 'Calle 15 #8-42, Oficina Contratación',
                'role_id' => $contratacionRole->id,
            ],
            [
                'name' => 'Carlos Alberto Ramírez',
                'email' => 'carlos.ramirez@municipio.gov.co',
                'password' => Hash::make('contratacion456'),
                'cedula' => '87654321',
                'telefono' => '3109876543',
                'direccion' => 'Carrera 20 #10-30, Edificio Municipal',
                'role_id' => $contratacionRole->id,
            ],
            [
                'name' => 'Ana Patricia Herrera',
                'email' => 'ana.herrera@municipio.gov.co',
                'password' => Hash::make('contratacion789'),
                'cedula' => '76543210',
                'telefono' => '3187654321',
                'direccion' => 'Avenida Principal #25-18',
                'role_id' => $contratacionRole->id,
            ]
        ];

        foreach ($contratacionUsers as $userData) {
            $existingUser = User::where('email', $userData['email'])->first();
            
            if (!$existingUser) {
                User::create($userData);
                $this->command->info("Usuario de contratación creado: {$userData['email']}");
            } else {
                $this->command->warn("Usuario ya existe: {$userData['email']}");
            }
        }

        $this->command->info('Seeder de usuarios de contratación completado.');
    }
}
