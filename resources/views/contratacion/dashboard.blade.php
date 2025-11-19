
@extends('layouts.app')

@section('title', 'Dashboard Contratación - CuentasCobro')

@section('content')
<!-- Contenedor principal del dashboard con padding superior para el navbar fijo -->
<div class="pt-24 pb-8 px-4 sm:px-6 lg:px-8 min-h-screen">
    <!-- Breadcrumb de navegación -->
    <div class="max-w-7xl mx-auto mb-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-500" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-700 transition-colors flex items-center">
                <i class="fas fa-home mr-1"></i>
                Inicio
            </a>
            <i class="fas fa-chevron-right text-gray-300"></i>
            <span class="text-gray-700 font-medium">Dashboard Contratación</span>
        </nav>
    </div>

    <!-- Header del dashboard -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="glass-card p-4 sm:p-6 slide-up">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Información del usuario -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="gradient-primary w-12 h-12 sm:w-16 sm:h-16 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-contract text-white text-lg sm:text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 font-poppins">
                            ¡Bienvenido, {{ $user->name }}!
                        </h1>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-gray-600 text-sm">Rol:</span>
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium gradient-secondary text-white shadow-sm">
                                <i class="fas fa-file-contract mr-1"></i>
                                {{ $user->role->name ? ucfirst($user->role->name) : 'Sin rol' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones rápidas -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <div class="flex items-center gap-3">
                        <button 
                            class="gradient-primary text-white px-3 sm:px-4 py-2 rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 font-medium text-sm flex items-center"
                            onclick="refreshDashboard()"
                            id="refresh-btn">
                            <i class="fas fa-sync-alt mr-2"></i>
                            <span class="hidden sm:inline">Actualizar</span>
                        </button>
                        <a href="{{ route('contratacion.contratos.create') }}" 
                           class="gradient-secondary text-white px-3 sm:px-4 py-2 rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 font-medium text-sm flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            <span class="hidden sm:inline">Nuevo Contrato</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notificaciones -->
    @if(count($notificaciones) > 0)
    <div class="max-w-7xl mx-auto mb-8">
        <div class="space-y-4">
            @foreach($notificaciones as $notif)
            <div class="glass-card p-4 border-l-4 
                @if($notif['tipo'] === 'warning') border-yellow-400
                @elseif($notif['tipo'] === 'danger') border-red-400
                @elseif($notif['tipo'] === 'success') border-green-400
                @else border-blue-400 @endif">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas {{ $notif['icono'] }} 
                            @if($notif['tipo'] === 'warning') text-yellow-500
                            @elseif($notif['tipo'] === 'danger') text-red-500
                            @elseif($notif['tipo'] === 'success') text-green-500
                            @else text-blue-500 @endif mr-3"></i>
                        <p class="text-gray-700 font-medium">{{ $notif['mensaje'] }}</p>
                    </div>
                    <a href="{{ $notif['url'] }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Ver <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Estadísticas principales -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total contratos -->
            <div class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Contratos</p>
                        <p class="text-3xl font-bold text-gray-800">{{ number_format($totalContratos) }}</p>
                        <p class="text-sm text-blue-600 flex items-center mt-1">
                            <i class="fas fa-file-contract mr-1"></i>
                            En el sistema
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-600 w-12 h-12 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-contract text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Contratos pendientes -->
            <div class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Pendientes</p>
                        <p class="text-3xl font-bold text-gray-800">{{ number_format($contratosPendientes) }}</p>
                        <p class="text-sm text-orange-600 flex items-center mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            Por revisar
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-orange-400 to-red-500 w-12 h-12 rounded-xl flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Valor total -->
            <div class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Valor Total</p>
                        <p class="text-3xl font-bold text-gray-800">${{ number_format($valorTotalContratos, 0) }}</p>
                        <p class="text-sm text-green-600 flex items-center mt-1">
                            <i class="fas fa-dollar-sign mr-1"></i>
                            Todos los contratos
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-green-400 to-emerald-600 w-12 h-12 rounded-xl flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Proveedores activos -->
            <div class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Proveedores Activos</p>
                        <p class="text-3xl font-bold text-gray-800">{{ number_format($proveedoresActivos) }}</p>
                        <p class="text-sm text-purple-600 flex items-center mt-1">
                            <i class="fas fa-users mr-1"></i>
                            Últimos 30 días
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-400 to-indigo-600 w-12 h-12 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas adicionales -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Contratos por estado -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-blue-600"></i>
                    Contratos por Estado
                </h3>
                <div class="space-y-3">
                    @foreach($contratosPorEstado as $estado)
                    @if($estado['count'] > 0)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $estado['color'] }}"></div>
                            <span class="text-gray-700">{{ $estado['estado'] }}</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ number_format($estado['count']) }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Últimos contratos -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-history mr-2 text-green-600"></i>
                    Últimos Contratos
                </h3>
                <div class="space-y-3">
                    @forelse($ultimosContratos as $contrato)
                    <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ Str::limit($contrato->proyecto_servicio, 30) }}</p>
                            <p class="text-xs text-gray-500">{{ $contrato->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-800 text-sm">${{ number_format($contrato->valor, 0) }}</p>
                            <p class="text-xs text-gray-500">{{ $contrato->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">No hay contratos recientes</p>
                    @endforelse
                </div>
            </div>

            <!-- Resumen del mes -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>
                    Este Mes
                </h3>
                <div class="space-y-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['contratos_este_mes']) }}</p>
                        <p class="text-gray-600 text-sm">Nuevos Contratos</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-800">${{ number_format($stats['valor_este_mes'], 0) }}</p>
                        <p class="text-gray-600 text-sm">Valor Total</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_proveedores']) }}</p>
                        <p class="text-gray-600 text-sm">Total Proveedores</p>

@extends('layouts.dashboard')

@section('title', 'Dashboard Contratación')

@section('breadcrumb')
    @include('components.navigation.breadcrumb', [
        'items' => [
            ['label' => 'Dashboard Contratación']
        ]
    ])
@endsection

@section('dashboard-header')
    <div class="glass-card p-6 slide-up">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="gradient-primary w-16 h-16 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-file-contract text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Contratación</h1>
                    <p class="text-gray-600">Bienvenido, {{ $user->name }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Último acceso</div>
                <div class="text-gray-800 font-medium">{{ now()->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>
@endsection

@section('dashboard-content')
    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Cuentas -->
        <div class="glass-card p-6 hover-scale">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 uppercase">Total</span>
            </div>
            <div class="text-3xl font-bold text-gray-800 mb-1">{{ $totalCuentas }}</div>
            <div class="text-sm text-gray-600">Cuentas de cobro</div>
        </div>

        <!-- Pendientes Contratación -->
        <div class="glass-card p-6 hover-scale">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 uppercase">Pendientes</span>
            </div>
            <div class="text-3xl font-bold text-yellow-600 mb-1">{{ $cuentasPendientesContratacion }}</div>
            <div class="text-sm text-gray-600">Requieren tu aprobación</div>
        </div>

        <!-- Aprobadas -->
        <div class="glass-card p-6 hover-scale">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 uppercase">Aprobadas</span>
            </div>
            <div class="text-3xl font-bold text-green-600 mb-1">{{ $cuentasAprobadas }}</div>
            <div class="text-sm text-gray-600">Cuentas aprobadas</div>
        </div>

        <!-- Valor Pendiente -->
        <div class="glass-card p-6 hover-scale">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 uppercase">Valor</span>
            </div>
            <div class="text-2xl font-bold text-purple-600 mb-1">${{ number_format($valorTotalPendiente, 0, ',', '.') }}</div>
            <div class="text-sm text-gray-600">Pendiente</div>
        </div>
    </div>

    <!-- Notificaciones y acciones rápidas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Notificaciones -->
        <div class="lg:col-span-2">
            <div class="glass-card p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-bell text-blue-500 mr-3"></i>
                    Notificaciones
                </h3>
                
                @if(count($notificaciones) > 0)
                    <div class="space-y-4">
                        @foreach($notificaciones as $notificacion)
                            <div class="border-l-4 rounded-lg p-4 transition-all hover:shadow-md
                                @if($notificacion['type'] === 'error') border-red-400 bg-red-50
                                @elseif($notificacion['type'] === 'warning') border-yellow-400 bg-yellow-50
                                @elseif($notificacion['type'] === 'success') border-green-400 bg-green-50
                                @else border-blue-400 bg-blue-50
                                @endif
                            ">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-3 flex-1">
                                        <div class="flex-shrink-0 mt-1">
                                            <i class="{{ $notificacion['icon'] }} 
                                                @if($notificacion['type'] === 'error') text-red-600
                                                @elseif($notificacion['type'] === 'warning') text-yellow-600
                                                @elseif($notificacion['type'] === 'success') text-green-600
                                                @else text-blue-600
                                                @endif
                                            "></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-800 mb-1">{{ $notificacion['title'] }}</h4>
                                            <p class="text-sm text-gray-700">{{ $notificacion['message'] }}</p>
                                        </div>
                                    </div>
                                    @if(isset($notificacion['action']))
                                        <a href="{{ $notificacion['action'] }}" 
                                           class="ml-4 px-4 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium transition-colors">
                                            {{ $notificacion['action_text'] ?? 'Ver' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                        <p class="text-gray-600">No hay notificaciones pendientes</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="space-y-6">
            <!-- Enlaces rápidos -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Acciones Rápidas
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('contratacion.cuentas-cobro.index') }}" 
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-xl font-medium transition-all text-center">
                        <i class="fas fa-list mr-2"></i>
                        Ver Todas las Cuentas
                    </a>
                    <a href="{{ route('contratacion.cuentas-cobro.index', ['estado' => 'pendiente_contratacion']) }}" 
                       class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white py-3 px-4 rounded-xl font-medium transition-all text-center">
                        <i class="fas fa-clock mr-2"></i>
                        Cuentas Pendientes
                    </a>
                </div>
            </div>

            <!-- Estadísticas del mes -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>
                    Este Mes
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Cuentas recibidas</span>
                        <span class="font-bold text-gray-800">{{ $estadisticasMes['cuentas_mes'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Aprobadas</span>
                        <span class="font-bold text-green-600">{{ $estadisticasMes['aprobadas_mes'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Rechazadas</span>
                        <span class="font-bold text-red-600">{{ $estadisticasMes['rechazadas_mes'] }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t">
                        <span class="text-gray-600">Valor total</span>
                        <span class="font-bold text-purple-600">${{ number_format($estadisticasMes['valor_mes'], 0, ',', '.') }}</span>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Acciones rápidas -->
    <div class="max-w-7xl mx-auto">
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                Acciones Rápidas
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('contratacion.contratos.index') }}" 
                   class="flex items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                    <div class="bg-blue-500 p-3 rounded-lg mr-4">
                        <i class="fas fa-list text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Ver Contratos</p>
                        <p class="text-sm text-gray-600">Gestionar todos</p>
                    </div>
                </a>
                
                <a href="{{ route('contratacion.contratos.create') }}" 
                   class="flex items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors group">
                    <div class="bg-green-500 p-3 rounded-lg mr-4">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Nuevo Contrato</p>
                        <p class="text-sm text-gray-600">Crear contrato</p>
                    </div>
                </a>
                
                <a href="{{ route('contratacion.proveedores.index') }}" 
                   class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors group">
                    <div class="bg-purple-500 p-3 rounded-lg mr-4">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Proveedores</p>
                        <p class="text-sm text-gray-600">Ver todos</p>
                    </div>
                </a>
                
                <a href="{{ route('contratacion.procesos.index') }}" 
                   class="flex items-center p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors group">
                    <div class="bg-orange-500 p-3 rounded-lg mr-4">
                        <i class="fas fa-cogs text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Procesos</p>
                        <p class="text-sm text-gray-600">Ver estados</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function refreshDashboard() {
    const btn = document.getElementById('refresh-btn');
    const icon = btn.querySelector('i');
    
    // Animar icono
    icon.classList.add('fa-spin');
    btn.disabled = true;
    
    // Simular actualización
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Auto-refresh cada 5 minutos
setInterval(refreshDashboard, 300000);
</script>

    <!-- Cuentas recientes pendientes -->
    <div class="glass-card p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-file-invoice text-purple-500 mr-3"></i>
            Cuentas Pendientes de Tu Aprobación
        </h3>
        
        @if($cuentasRecientes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">ID</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Contratista</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Proyecto</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Valor</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Fecha</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-700">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuentasRecientes as $cuenta)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-4">
                                    <span class="font-medium text-gray-800">#{{ $cuenta->id }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-gray-800">{{ $cuenta->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $cuenta->user->email }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-sm text-gray-800">{{ Str::limit($cuenta->proyecto_servicio, 40) }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-semibold text-green-600">${{ number_format($cuenta->valor, 0, ',', '.') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-sm text-gray-600">{{ $cuenta->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $cuenta->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('contratacion.cuentas-cobro.show', $cuenta->id) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        <i class="fas fa-eye mr-1"></i>
                                        Revisar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                <p class="text-gray-600">No hay cuentas pendientes de tu aprobación</p>
            </div>
        @endif
    </div>
@endsection
