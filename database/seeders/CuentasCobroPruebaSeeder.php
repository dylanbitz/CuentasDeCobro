<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuentaCobro;
use App\Models\User;
use App\Models\Roles;
use Carbon\Carbon;

class CuentasCobroPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios contratistas para asignar cuentas
        $contratistaRole = Roles::where('name', 'contratista')->first();
        
        if (!$contratistaRole) {
            $this->command->error('❌ No se encontró el rol de contratista. Ejecuta primero el RoleSeeder.');
            return;
        }

        $contratistas = User::where('role_id', $contratistaRole->id)->get();
        
        if ($contratistas->isEmpty()) {
            // Crear algunos contratistas de prueba
            $contratistas = collect([
                User::create([
                    'name' => 'Juan Pérez Contratista',
                    'email' => 'juan.contratista@test.com',
                    'password' => bcrypt('password123'),
                    'role_id' => $contratistaRole->id,
                ]),
                User::create([
                    'name' => 'Ana García Contratista',
                    'email' => 'ana.contratista@test.com', 
                    'password' => bcrypt('password123'),
                    'role_id' => $contratistaRole->id,
                ]),
                User::create([
                    'name' => 'Carlos Rodríguez Contratista',
                    'email' => 'carlos.contratista@test.com',
                    'password' => bcrypt('password123'),
                    'role_id' => $contratistaRole->id,
                ])
            ]);
            
            $this->command->info('✅ Contratistas de prueba creados.');
        }

        // Datos de cuentas de cobro de prueba
        $cuentasPrueba = [
            [
                'proyecto_servicio' => 'Desarrollo de Sistema de Inventario Municipal',
                'valor' => 2500000,
                'descripcion' => 'Desarrollo completo del sistema de inventario para la alcaldía municipal incluyendo módulos de entrada, salida y reportes.',
                'estado' => CuentaCobro::ESTADO_APROBADO, // Para que el ordenador pueda autorizarlas
                'fecha_emision' => Carbon::now()->subDays(5),
            ],
            [
                'proyecto_servicio' => 'Mantenimiento de Infraestructura de Red',
                'valor' => 1800000,
                'descripcion' => 'Mantenimiento preventivo y correctivo de la infraestructura de red del municipio.',
                'estado' => CuentaCobro::ESTADO_APROBADO,
                'fecha_emision' => Carbon::now()->subDays(3),
            ],
            [
                'proyecto_servicio' => 'Consultoría en Gestión Documental',
                'valor' => 1200000,
                'descripcion' => 'Asesoría para implementación de sistema de gestión documental digital.',
                'estado' => CuentaCobro::ESTADO_APROBADO,
                'fecha_emision' => Carbon::now()->subDays(7),
            ],
            [
                'proyecto_servicio' => 'Capacitación en Seguridad Informática',
                'valor' => 900000,
                'descripcion' => 'Programa de capacitación para empleados municipales en seguridad informática.',
                'estado' => CuentaCobro::ESTADO_APROBADO,
                'fecha_emision' => Carbon::now()->subDays(2),
            ],
            [
                'proyecto_servicio' => 'Desarrollo de Portal Web Ciudadano',
                'valor' => 3200000,
                'descripcion' => 'Creación de portal web para servicios ciudadanos en línea.',
                'estado' => CuentaCobro::ESTADO_APROBADO,
                'fecha_emision' => Carbon::now()->subDays(10),
            ],
            // Algunas cuentas ya pagadas para el historial del ordenador
            [
                'proyecto_servicio' => 'Auditoría de Sistemas de Información',
                'valor' => 1500000,
                'descripcion' => 'Auditoría completa de los sistemas de información municipales.',
                'estado' => CuentaCobro::ESTADO_PAGADO,
                'fecha_emision' => Carbon::now()->subDays(20),
            ],
            [
                'proyecto_servicio' => 'Implementación de Backup Automático',
                'valor' => 800000,
                'descripcion' => 'Configuración de sistema de respaldo automático para datos críticos.',
                'estado' => CuentaCobro::ESTADO_PAGADO,
                'fecha_emision' => Carbon::now()->subDays(25),
            ]
        ];

        foreach ($cuentasPrueba as $index => $cuentaData) {
            // Asignar contratista aleatoriamente
            $contratista = $contratistas->random();
            
            $cuenta = CuentaCobro::create([
                'user_id' => $contratista->id,
                'fecha_emision' => $cuentaData['fecha_emision'],
                'proyecto_servicio' => $cuentaData['proyecto_servicio'],
                'valor' => $cuentaData['valor'],
                'estado' => $cuentaData['estado'],
                'descripcion' => $cuentaData['descripcion'],
                'created_at' => $cuentaData['fecha_emision'],
                'updated_at' => $cuentaData['estado'] === CuentaCobro::ESTADO_PAGADO 
                    ? $cuentaData['fecha_emision']->addDays(3) 
                    : $cuentaData['fecha_emision']->addDays(1),
            ]);
            
            $this->command->info("✅ Cuenta de cobro #{$cuenta->id} creada: {$cuentaData['proyecto_servicio']} - Estado: {$cuentaData['estado']}");
        }

        $totalAprobadas = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->count();
        $totalPagadas = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->count();
        
        $this->command->info('🎉 Cuentas de cobro de prueba creadas exitosamente!');
        $this->command->line('');
        $this->command->line("📊 Resumen:");
        $this->command->line("   • {$totalAprobadas} cuentas aprobadas (pendientes de autorización)");
        $this->command->line("   • {$totalPagadas} cuentas pagadas (historial autorizado)");
        $this->command->line('');
        $this->command->line('🔑 Ahora puedes probar el módulo del ordenador con:');
        $this->command->line('   📧 Email: ordenador@municipio.gov.co');
        $this->command->line('   🔒 Password: ordenador123');
    }
}
