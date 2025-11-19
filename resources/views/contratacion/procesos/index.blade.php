@extends('layouts.app')

@section('title', 'Gestión de Procesos - Contratación')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 relative overflow-hidden">
    <!-- Background Animation -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-80 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-80 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-80 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10" style="min-height: 100vh;">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('contratacion.dashboard') }}" class="text-gray-700 hover:text-indigo-600 inline-flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Procesos</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-2xl border border-white/30 p-8">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                    <div class="mb-6 lg:mb-0">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 rounded-2xl shadow-lg mr-4">
                                <i class="fas fa-cogs text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    Gestión de Procesos
                                </h1>
                                <p class="text-gray-600 text-lg mt-1">Seguimiento y administración de procesos contractuales</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-6 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-chart-bar text-indigo-500 mr-2"></i>
                                {{ count($procesos) }} procesos activos
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-sync-alt text-indigo-500 mr-2"></i>
                                Actualizado en tiempo real
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('contratacion.contratos.index') }}" 
                           class="bg-white/70 hover:bg-white text-indigo-700 border-2 border-indigo-200 hover:border-indigo-300 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            <i class="fas fa-file-contract mr-2"></i>
                            Ver Contratos
                        </a>
                        <a href="{{ route('contratacion.contratos.create') }}" 
                           class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            <i class="fas fa-plus mr-2"></i>
                            Nuevo Contrato
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Generales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Procesos -->
            <div class="bg-white rounded-2xl p-6 shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-tasks text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center text-xs text-indigo-600 font-semibold">
                            <i class="fas fa-chart-line mr-1"></i>
                            Vista completa
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Total Procesos</p>
                    <p class="text-3xl font-bold text-gray-800">{{ count($procesos) }}</p>
                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-cogs mr-1"></i>
                        Estados disponibles
                    </p>
                </div>
            </div>

            <!-- Contratos Activos -->
            <div class="bg-white rounded-2xl p-6 shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-play-circle text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center text-xs text-green-600 font-semibold">
                            <i class="fas fa-arrow-up mr-1"></i>
                            +15%
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Contratos Activos</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['contratos_activos'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-rocket mr-1"></i>
                        En ejecución
                    </p>
                </div>
            </div>

            <!-- Valor en Proceso -->
            <div class="bg-white rounded-2xl p-6 shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-dollar-sign text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center text-xs text-yellow-600 font-semibold">
                            <i class="fas fa-chart-line mr-1"></i>
                            Monitoreo
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Valor en Proceso</p>
                    <p class="text-3xl font-bold text-gray-800">${{ number_format($stats['valor_proceso'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-coins mr-1"></i>
                        Valor total activo
                    </p>
                </div>
            </div>

            <!-- Eficiencia -->
            <div class="bg-white rounded-2xl p-6 shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-pie text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center text-xs text-purple-600 font-semibold">
                            <i class="fas fa-arrow-up mr-1"></i>
                            +5%
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Eficiencia</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['eficiencia'] ?? 0 }}%</p>
                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-target mr-1"></i>
                        Promedio mensual
                    </p>
                </div>
            </div>
        </div>        <!-- Estados de Procesos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            @foreach($procesos as $proceso)
            <div class="proceso-card bg-white rounded-2xl shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group cursor-pointer"
                 onclick="viewProceso('{{ $proceso['filtro_estado'] }}')">
                
                <!-- Header del Proceso -->
                <div class="bg-gradient-to-r {{ $proceso['color_gradient'] }} p-6 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-white/20 p-3 rounded-xl">
                                <i class="{{ $proceso['icono'] }} text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-white font-bold text-xl">{{ $proceso['nombre'] }}</h3>
                                <p class="text-white/80 text-sm">{{ $proceso['descripcion'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white text-3xl font-bold">{{ count($proceso['contratos']) }}</div>
                            <div class="text-white/80 text-xs">contratos</div>
                        </div>
                    </div>
                </div>

                <!-- Contenido del Proceso -->
                <div class="p-6">
                    <!-- Estadísticas del Proceso -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center">                            <div class="text-2xl font-bold text-green-600">
                                ${{ number_format($proceso['valor_total'] ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500">Valor Total</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $proceso['proveedores_unicos'] }}
                            </div>
                            <div class="text-xs text-gray-500">Proveedores</div>
                        </div>
                    </div>

                    <!-- Barra de Progreso -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Progreso del Proceso</span>
                            <span class="font-semibold text-gray-800">{{ $proceso['porcentaje'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r {{ $proceso['color_gradient'] }} h-3 rounded-full transition-all duration-1000" 
                                 style="width: {{ $proceso['porcentaje'] }}%"></div>
                        </div>
                    </div>

                    <!-- Contratos Recientes -->
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-clock text-gray-500 mr-2"></i>
                            Actividad Reciente
                        </h4>
                        @if(count($proceso['contratos']) > 0)
                            <div class="space-y-2">                                @foreach(array_slice($proceso['contratos'], 0, 3) as $contrato)
                                <div class="flex items-center justify-between text-sm bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-{{ $proceso['color'] }}-500 rounded-full mr-2"></div>
                                        <span class="font-medium text-gray-800">Contrato #{{ $contrato['id'] }}</span>
                                    </div>
                                    <span class="text-green-600 font-semibold">
                                        ${{ number_format($contrato['valor'] ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                                @endforeach
                                @if(count($proceso['contratos']) > 3)
                                <div class="text-center">
                                    <span class="text-xs text-gray-500">
                                        +{{ count($proceso['contratos']) - 3 }} contratos más
                                    </span>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox text-gray-300 text-2xl mb-2"></i>
                                <p class="text-xs text-gray-500">No hay contratos en este proceso</p>
                            </div>
                        @endif
                    </div>

                    <!-- Acciones -->
                    <div class="flex space-x-3">
                        <button onclick="viewProceso('{{ $proceso['filtro_estado'] }}')" 
                                class="flex-1 bg-gradient-to-r {{ $proceso['color_gradient'] }} text-white px-4 py-3 rounded-xl font-semibold transition-all duration-300 transform group-hover:scale-105 text-center hover:shadow-lg">
                            <i class="fas fa-eye mr-2"></i>
                            Ver Detalles
                        </button>
                        <button onclick="filterContratos('{{ $proceso['filtro_estado'] }}')" 
                                class="bg-white/70 hover:bg-white text-gray-700 border-2 border-gray-200 hover:border-gray-300 px-4 py-3 rounded-xl transition-all duration-300">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Panel de Análisis -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Gráfico de Distribución -->
            <div class="bg-white rounded-2xl shadow-xl border border-white/30">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 rounded-t-2xl">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-chart-pie mr-3"></i>
                        Distribución por Estado
                    </h3>
                </div>
                <div class="p-6">
                    <div class="h-64">
                        <canvas id="distribucionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Métricas de Rendimiento -->
            <div class="bg-white rounded-2xl shadow-xl border border-white/30">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4 rounded-t-2xl">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-chart-line mr-3"></i>
                        Métricas de Rendimiento
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Tiempo Promedio por Proceso -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700 font-medium">Tiempo Promedio</span>
                                <span class="text-purple-600 font-bold">{{ $stats['tiempo_promedio'] ?? 0 }} días</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>

                        <!-- Eficiencia General -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700 font-medium">Eficiencia General</span>
                                <span class="text-green-600 font-bold">{{ $stats['eficiencia'] ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['eficiencia'] ?? 0 }}%"></div>
                            </div>
                        </div>

                        <!-- Contratos por Mes -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700 font-medium">Contratos/Mes</span>
                                <span class="text-blue-600 font-bold">{{ $stats['contratos_mes'] ?? 0 }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>

                        <!-- Valor Promedio -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700 font-medium">Valor Promedio</span>
                                <span class="text-yellow-600 font-bold">${{ number_format($stats['valor_promedio'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-2xl shadow-xl border border-white/30 p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-bolt text-indigo-500 mr-3"></i>
                Acciones Rápidas
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <button onclick="crearContrato()" 
                        class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white p-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-plus text-2xl mb-3"></i>
                    <div class="text-lg">Crear Contrato</div>
                    <div class="text-sm opacity-80">Nuevo proceso</div>
                </button>

                <button onclick="generarReporte()" 
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-chart-bar text-2xl mb-3"></i>
                    <div class="text-lg">Generar Reporte</div>
                    <div class="text-sm opacity-80">Análisis detallado</div>
                </button>

                <button onclick="exportarDatos()" 
                        class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-download text-2xl mb-3"></i>
                    <div class="text-lg">Exportar Datos</div>
                    <div class="text-sm opacity-80">Excel/PDF</div>
                </button>

                <button onclick="configurarAlertas()" 
                        class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-bell text-2xl mb-3"></i>
                    <div class="text-lg">Configurar Alertas</div>
                    <div class="text-sm opacity-80">Notificaciones</div>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de distribución
const ctx = document.getElementById('distribucionChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_column($procesos->toArray(), 'nombre')) !!},
        datasets: [{
            data: {!! json_encode(array_map(function($p) { return count($p['contratos']); }, $procesos->toArray())) !!},
            backgroundColor: [
                '#F59E0B', // yellow - pendiente
                '#10B981', // green - aprobado  
                '#3B82F6', // blue - en_proceso
                '#8B5CF6', // purple - completado
                '#EF4444'  // red - rechazado
            ],
            borderWidth: 3,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            }
        },
        cutout: '60%'
    }
});

// Funciones JavaScript
function viewProceso(estado) {
    window.location.href = `/contratacion/procesos/${estado}`;
}

function filterContratos(estado) {
    window.location.href = `/contratacion/contratos?estado=${estado}`;
}

function crearContrato() {
    window.location.href = '{{ route("contratacion.contratos.create") }}';
}

function generarReporte() {
    Swal.fire({
        title: 'Generar Reporte',
        html: `
            <div class="space-y-4">
                <select id="tipoReporte" class="w-full p-3 border rounded-lg">
                    <option value="general">Reporte General</option>
                    <option value="por_estado">Por Estado</option>
                    <option value="por_proveedor">Por Proveedor</option>
                    <option value="financiero">Financiero</option>
                </select>
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" id="fechaInicio" class="p-3 border rounded-lg" placeholder="Fecha Inicio">
                    <input type="date" id="fechaFin" class="p-3 border rounded-lg" placeholder="Fecha Fin">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Generar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#3B82F6'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Reporte generado',
                text: 'El reporte se está procesando y será enviado por email',
                timer: 3000,
                showConfirmButton: false
            });
        }
    });
}

function exportarDatos() {
    Swal.fire({
        title: 'Exportar Datos',
        text: '¿En qué formato deseas exportar?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-file-excel mr-2"></i>Excel',
        cancelButtonText: '<i class="fas fa-file-pdf mr-2"></i>PDF',
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#EF4444'
    });
}

function configurarAlertas() {
    Swal.fire({
        title: 'Configurar Alertas',
        html: `
            <div class="space-y-4 text-left">
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Contratos próximos a vencer
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Nuevos contratos pendientes
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Cambios de estado
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Reportes semanales
                </label>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
    });
}

// Animaciones CSS
const style = document.createElement('style');
style.textContent = `
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .proceso-card {
        cursor: pointer;
    }
    
    .proceso-card:hover {
        transform: translateY(-8px) scale(1.02);
    }
`;
document.head.appendChild(style);
</script>

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

            <div class="bg-white rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-200 text-sm">Completados</p>
                        <p class="text-white text-2xl font-bold">{{ $procesosCompletados }}</p>
                    </div>
                    <div class="bg-green-500/20 p-3 rounded-lg">
                        <i class="fas fa-check-circle text-green-300 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-200 text-sm">Valor Total</p>
                        <p class="text-white text-2xl font-bold">${{ number_format($valorTotal, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-purple-500/20 p-3 rounded-lg">
                        <i class="fas fa-dollar-sign text-purple-300 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl p-6 mb-8">
            <form method="GET" action="{{ route('contratacion.procesos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-white font-medium mb-2">Estado</label>
                    <select name="estado" class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white">
                        <option value="" class="bg-gray-800">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }} class="bg-gray-800">Pendiente</option>
                        <option value="revision" {{ request('estado') == 'revision' ? 'selected' : '' }} class="bg-gray-800">En Revisión</option>
                        <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }} class="bg-gray-800">Aprobado</option>
                        <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }} class="bg-gray-800">Pagado</option>
                        <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }} class="bg-gray-800">Rechazado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-white font-medium mb-2">Proveedor</label>
                    <select name="proveedor" class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white">
                        <option value="" class="bg-gray-800">Todos los proveedores</option>
                        @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ request('proveedor') == $proveedor->id ? 'selected' : '' }} class="bg-gray-800">
                            {{ $proveedor->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-white font-medium mb-2">Fecha Desde</label>
                    <input type="date" 
                           name="fecha_desde" 
                           value="{{ request('fecha_desde') }}"
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white">
                </div>

                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Procesos por Estado -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($procesosPorEstado as $estado => $procesos)
            <div class="bg-white rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        @if($estado === 'pendiente')
                            <span class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></span>
                            Pendientes
                        @elseif($estado === 'revision')
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                            En Revisión
                        @elseif($estado === 'aprobado')
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                            Aprobados
                        @elseif($estado === 'pagado')
                            <span class="w-3 h-3 bg-purple-500 rounded-full mr-3"></span>
                            Pagados
                        @else
                            <span class="w-3 h-3 bg-red-500 rounded-full mr-3"></span>
                            Rechazados
                        @endif
                    </h3>
                    <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">
                        {{ $procesos->count() }}
                    </span>
                </div>

                <div class="space-y-4 max-h-80 overflow-y-auto">
                    @forelse($procesos->take(5) as $proceso)
                    <div class="bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-white font-medium">
                                CON-{{ str_pad($proceso->id, 6, '0', STR_PAD_LEFT) }}
                            </h4>
                            <span class="text-blue-200 text-sm">
                                {{ $proceso->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        
                        <p class="text-blue-200 text-sm mb-2">{{ $proceso->concepto }}</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-white font-bold">
                                ${{ number_format($proceso->valor, 0, ',', '.') }}
                            </span>
                            <div class="flex space-x-2">
                                <a href="{{ route('contratacion.contratos.show', $proceso->id) }}" 
                                   class="text-blue-300 hover:text-blue-200 transition-colors text-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($proceso->estado !== 'pagado')
                                <a href="{{ route('contratacion.contratos.edit', $proceso->id) }}" 
                                   class="text-green-300 hover:text-green-200 transition-colors text-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        @if($proceso->user)
                        <p class="text-blue-200 text-xs mt-2">
                            <i class="fas fa-user mr-1"></i>{{ $proceso->user->name }}
                        </p>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">No hay procesos en este estado</p>
                    </div>
                    @endforelse

                    @if($procesos->count() > 5)
                    <div class="text-center pt-4">
                        <a href="{{ route('contratacion.procesos.show', $estado) }}" 
                           class="text-blue-300 hover:text-blue-200 text-sm transition-colors">
                            Ver todos ({{ $procesos->count() - 5 }} más) →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Gráfico de Procesos -->
        <div class="mt-8">
            <div class="bg-white rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-chart-line mr-3 text-blue-300"></i>
                    Evolución de Procesos (Últimos 30 días)
                </h3>
                
                <div class="relative" style="height: 300px;">
                    <canvas id="procesosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Procesos Recientes -->
        <div class="mt-8">
            <div class="bg-white rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clock mr-3 text-blue-300"></i>
                        Actividad Reciente
                    </h3>
                    <a href="{{ route('contratacion.contratos.index') }}" 
                       class="text-blue-300 hover:text-blue-200 text-sm transition-colors">
                        Ver todos →
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($procesosRecientes as $proceso)
                    <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                @if($proceso->estado === 'pendiente') bg-yellow-500/20
                                @elseif($proceso->estado === 'revision') bg-blue-500/20
                                @elseif($proceso->estado === 'aprobado') bg-green-500/20
                                @elseif($proceso->estado === 'pagado') bg-purple-500/20
                                @else bg-red-500/20
                                @endif">
                                <i class="fas fa-file-contract text-sm
                                    @if($proceso->estado === 'pendiente') text-yellow-300
                                    @elseif($proceso->estado === 'revision') text-blue-300
                                    @elseif($proceso->estado === 'aprobado') text-green-300
                                    @elseif($proceso->estado === 'pagado') text-purple-300
                                    @else text-red-300
                                    @endif"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-medium">
                                    CON-{{ str_pad($proceso->id, 6, '0', STR_PAD_LEFT) }} - {{ $proceso->concepto }}
                                </h4>
                                <p class="text-blue-200 text-sm">
                                    {{ $proceso->user->name ?? 'N/A' }} • ${{ number_format($proceso->valor, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($proceso->estado === 'pendiente') bg-yellow-500/20 text-yellow-300
                                @elseif($proceso->estado === 'revision') bg-blue-500/20 text-blue-300
                                @elseif($proceso->estado === 'aprobado') bg-green-500/20 text-green-300
                                @elseif($proceso->estado === 'pagado') bg-purple-500/20 text-purple-300
                                @else bg-red-500/20 text-red-300
                                @endif">
                                {{ ucfirst($proceso->estado) }}
                            </span>
                            <p class="text-blue-200 text-xs mt-1">
                                {{ $proceso->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">No hay actividad reciente</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de evolución de procesos
    const ctx = document.getElementById('procesosChart').getContext('2d');
    
    // Datos de ejemplo - en producción vendrían del controlador
    const chartData = {
        labels: @json($chartLabels ?? []),
        datasets: [{
            label: 'Procesos Creados',
            data: @json($chartData ?? []),
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    };

    new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                y: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    });

    // Auto-refresh cada 30 segundos
    setInterval(function() {
        window.location.reload();
    }, 30000);
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Éxito',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'Ok'
    });
</script>
@endif
@endsection
