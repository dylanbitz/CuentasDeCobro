@extends('layouts.app')

@section('title', 'Mi Perfil - Contratación')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-user-cog text-indigo-600 mr-3"></i>
                        Mi Perfil
                    </h1>
                    <p class="text-gray-600 text-lg">Información personal y estadísticas de gestión</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('contratacion.dashboard') }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Información Personal -->
            <div class="xl:col-span-1 space-y-6">
                <!-- Tarjeta de Perfil -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8 text-center">
                        <div class="h-24 w-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-tie text-indigo-600 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $user->name }}</h3>
                        <p class="text-indigo-100 text-lg">Gestor de Contratación</p>
                        <div class="mt-4 inline-flex items-center bg-white/20 rounded-full px-4 py-2">
                            <i class="fas fa-briefcase text-white mr-2"></i>
                            <span class="text-white font-medium">{{ $user->role->name ?? 'Sin rol' }}</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                            <span class="text-gray-700">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            <span class="text-gray-700">Miembro desde {{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span class="text-gray-700">Última conexión: {{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Configuración de Cuenta -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-cogs mr-2"></i>
                            Configuración de Cuenta
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <button class="w-full text-left p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-key text-indigo-600"></i>
                                <span class="text-gray-700">Cambiar Contraseña</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                        <button class="w-full text-left p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-bell text-indigo-600"></i>
                                <span class="text-gray-700">Notificaciones</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                        <button class="w-full text-left p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-shield-alt text-indigo-600"></i>
                                <span class="text-gray-700">Seguridad</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Estadísticas y Desempeño -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Métricas de Gestión -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-chart-line mr-2"></i>
                            Métricas de Gestión
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contratos Gestionados -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-800">Contratos Gestionados</h4>
                                    <i class="fas fa-file-contract text-blue-600 text-2xl"></i>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-3xl font-bold text-blue-600">{{ $stats['contratos_gestionados'] }}</p>
                                    <p class="text-sm text-gray-600">Total en el sistema</p>
                                    <div class="flex items-center space-x-2 text-sm">
                                        <span class="text-green-600">
                                            <i class="fas fa-plus mr-1"></i>
                                            {{ $stats['contratos_este_mes'] }}
                                        </span>
                                        <span class="text-gray-500">este mes</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Valor Total Gestionado -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-800">Valor Total Gestionado</h4>
                                    <i class="fas fa-dollar-sign text-green-600 text-2xl"></i>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-3xl font-bold text-green-600">${{ number_format($stats['valor_total_gestionado'], 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-600">Monto total procesado</p>
                                    <div class="flex items-center space-x-2 text-sm">
                                        <span class="text-blue-600">
                                            <i class="fas fa-calculator mr-1"></i>
                                            ${{ number_format($stats['valor_total_gestionado'] / max($stats['contratos_gestionados'], 1), 0, ',', '.') }}
                                        </span>
                                        <span class="text-gray-500">promedio por contrato</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Proveedores Activos -->
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-800">Proveedores Activos</h4>
                                    <i class="fas fa-users text-purple-600 text-2xl"></i>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-3xl font-bold text-purple-600">{{ $stats['proveedores_activos'] }}</p>
                                    <p class="text-sm text-gray-600">en la plataforma</p>
                                    <div class="flex items-center space-x-2 text-sm">
                                        <span class="text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Verificados
                                        </span>
                                        <span class="text-gray-500">y activos</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Este Mes -->
                            <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-6 border border-orange-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-800">Este Mes</h4>
                                    <i class="fas fa-calendar-month text-orange-600 text-2xl"></i>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-3xl font-bold text-orange-600">{{ $stats['contratos_este_mes'] }}</p>
                                    <p class="text-sm text-gray-600">contratos gestionados</p>
                                    <div class="flex items-center space-x-2 text-sm">
                                        <span class="text-indigo-600">
                                            <i class="fas fa-chart-line mr-1"></i>
                                            Activo
                                        </span>
                                        <span class="text-gray-500">en gestión</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Actividad -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Actividad Últimos 7 Días
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="actividadChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Actividad Reciente -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-history mr-2"></i>
                            Actividad Reciente
                        </h3>
                    </div>
                    <div class="p-6">
                        @if(count($actividad_reciente) > 0)
                        <div class="space-y-4">
                            @foreach($actividad_reciente as $actividad)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="h-10 w-10 bg-{{ $actividad['color'] }}-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-{{ $actividad['icon'] }} text-{{ $actividad['color'] }}-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $actividad['descripcion'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $actividad['tiempo'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($actividad['valor'], 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Contrato #{{ $actividad['contrato_id'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <i class="fas fa-history text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">No hay actividad reciente</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Accesos Rápidos -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-lightning-bolt mr-2"></i>
                            Accesos Rápidos
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('contratacion.contratos.create') }}" 
                               class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                                <i class="fas fa-plus-circle text-2xl mb-2"></i>
                                <div class="text-sm">Nuevo Contrato</div>
                            </a>
                            <a href="{{ route('contratacion.proveedores.index') }}" 
                               class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                                <i class="fas fa-users text-2xl mb-2"></i>
                                <div class="text-sm">Ver Proveedores</div>
                            </a>
                            <a href="{{ route('contratacion.procesos.index') }}" 
                               class="bg-purple-600 hover:bg-purple-700 text-white p-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                                <i class="fas fa-cogs text-2xl mb-2"></i>
                                <div class="text-sm">Ver Procesos</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de actividad
    const ctx = document.getElementById('actividadChart').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.8)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.1)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_data['labels']) !!},
            datasets: [{
                label: 'Contratos por día',
                data: {!! json_encode($chart_data['data']) !!},
                backgroundColor: gradient,
                borderColor: 'rgb(99, 102, 241)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(99, 102, 241)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(99, 102, 241)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            size: 12
                        }
                    }
                }
            },
            elements: {
                point: {
                    hoverRadius: 8
                }
            }
        }
    });
});
</script>

<!-- SweetAlert para notificaciones -->
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 3000
    });
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session("error") }}',
        showConfirmButton: true
    });
});
</script>
@endif
@endsection
