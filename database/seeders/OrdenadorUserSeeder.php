<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Roles;

class OrdenadorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si existe el rol de ordenador
        $ordenadorRole = Roles::where('name', 'ordenador')->first();
        
        if (!$ordenadorRole) {
            // Crear el rol si no existe
            $ordenadorRole = Roles::create([
                'name' => 'ordenador',
                'description' => 'Ordenador del Gasto - Autoriza las cuentas de cobro aprobadas por el supervisor antes de enviarlas a tesorería',
                'permissions' => [
                    'ordenador.dashboard',
                    'ordenador.autorizaciones.index',
                    'ordenador.autorizaciones.show',
                    'ordenador.autorizaciones.autorizar',
                    'ordenador.ordenes.index',
                    'ordenador.ordenes.show',
                    'ordenador.perfil'
                ]
            ]);
            
            $this->command->info('✅ Rol de ordenador creado correctamente.');
        } else {
            $this->command->info('ℹ️  El rol de ordenador ya existe.');
        }

        // Crear usuarios de prueba con rol de ordenador
        $ordenadores = [
            [
                'name' => 'María Fernández',
                'email' => 'ordenador@municipio.gov.co',
                'password' => Hash::make('ordenador123'),
                'role_id' => $ordenadorRole->id,
            ],
            [
                'name' => 'Carlos Ramírez',
                'email' => 'carlos.ordenador@municipio.gov.co',
                'password' => Hash::make('ordenador456'),
                'role_id' => $ordenadorRole->id,
            ]
        ];

        foreach ($ordenadores as $ordenadorData) {
            // Verificar si el usuario ya existe
            $existingUser = User::where('email', $ordenadorData['email'])->first();
            
            if (!$existingUser) {
                $user = User::create($ordenadorData);
                $this->command->info("✅ Usuario ordenador creado: {$user->name} ({$user->email})");
            } else {
                // Si existe, actualizar el rol
                $existingUser->update(['role_id' => $ordenadorRole->id]);
                $this->command->info("ℹ️  Usuario {$existingUser->name} actualizado con rol de ordenador.");
            }
        }

        $this->command->info('🎉 Seeder de usuarios ordenador completado.');
        $this->command->line('');
        $this->command->line('📋 Credenciales de acceso:');
        $this->command->line('   • Email: ordenador@municipio.gov.co');
        $this->command->line('   • Password: ordenador123');
        $this->command->line('');
        $this->command->line('   • Email: carlos.ordenador@municipio.gov.co');
        $this->command->line('   • Password: ordenador456');
    }
}
