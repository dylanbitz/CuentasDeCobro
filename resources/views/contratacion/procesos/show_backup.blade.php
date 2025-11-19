@extends('layouts.app')

@section('title', 'Detalle del Proceso - Contratación')

@section('content')
<!-- Debug temporal - quitar después -->
@if(config('app.debug'))
<div style="background: #000; color: #0f0; padding: 10px; font-family: monospace; font-size: 12px;">
    <strong>DEBUG DATOS:</strong><br>
    Estado: {{ $estado ?? 'NULL' }}<br>
    Nombre Proceso: {{ $nombreProceso ?? 'NULL' }}<br>
    Total Contratos: {{ $estadisticas['total_contratos'] ?? 'NULL' }}<br>
    Valor Total: {{ $estadisticas['valor_total'] ?? 'NULL' }}<br>
    Contratos Count: {{ $contratos->count() ?? 'NULL' }}<br>
    Contratos Total: {{ $contratos->total() ?? 'NULL' }}
</div>
@endif

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-indigo-50 to-blue-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('contratacion.dashboard') }}" class="text-gray-700 hover:text-purple-600">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <a href="{{ route('contratacion.procesos.index') }}" class="text-gray-700 hover:text-purple-600">Procesos</a>
                                </div>                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <span class="text-gray-500">{{ $nombreProceso }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2 mt-4">
                        <i class="fas fa-cogs text-purple-600 mr-3"></i>
                        {{ $nombreProceso }}
                    </h1>
                    <p class="text-gray-600 text-lg">Gestión y seguimiento del proceso contractual</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('contratacion.procesos.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas del Proceso -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Contratos en Proceso -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 p-6 transform hover:scale-105 transition-all duration-300">                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Contratos</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $estadisticas['total_contratos'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-file-contract text-purple-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    En este proceso
                </p>
            </div>

            <!-- Valor Total -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 p-6 transform hover:scale-105 transition-all duration-300">                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Valor Total</p>
                        <p class="text-3xl font-bold text-green-600">${{ number_format($estadisticas['valor_total'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-coins mr-1"></i>
                    Suma de contratos
                </p>
            </div>

            <!-- Proveedores Únicos -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 p-6 transform hover:scale-105 transition-all duration-300">                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Proveedores</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $contratos->pluck('user_id')->unique()->count() }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-user-check mr-1"></i>
                    Proveedores únicos
                </p>
            </div>

            <!-- Promedio Días en Proceso -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Promedio Días</p>
                        <p class="text-3xl font-bold text-orange-600">{{ number_format($estadisticas['promedio_dias'] ?? 0, 0) }}</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <i class="fas fa-calculator text-orange-600 text-xl"></i>
                    </div>                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    En este proceso
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información del Proceso -->
            <div class="lg:col-span-1">
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 mb-6">
                    @php
                        $estadoConfig = [
                            'borrador' => ['gradient' => 'from-gray-600 to-gray-700', 'icon' => 'fas fa-pencil-alt', 'badge' => 'bg-gray-100 text-gray-800'],
                            'pendiente' => ['gradient' => 'from-yellow-600 to-orange-600', 'icon' => 'fas fa-clock', 'badge' => 'bg-yellow-100 text-yellow-800'],
                            'revision' => ['gradient' => 'from-blue-600 to-indigo-600', 'icon' => 'fas fa-search', 'badge' => 'bg-blue-100 text-blue-800'],
                            'aprobado' => ['gradient' => 'from-green-600 to-emerald-600', 'icon' => 'fas fa-check-circle', 'badge' => 'bg-green-100 text-green-800'],
                            'rechazado' => ['gradient' => 'from-red-600 to-red-700', 'icon' => 'fas fa-times-circle', 'badge' => 'bg-red-100 text-red-800'],
                            'pagado' => ['gradient' => 'from-purple-600 to-violet-600', 'icon' => 'fas fa-dollar-sign', 'badge' => 'bg-purple-100 text-purple-800']
                        ];
                        $config = $estadoConfig[$estado] ?? $estadoConfig['pendiente'];
                    @endphp
                    <div class="bg-gradient-to-r {{ $config['gradient'] }} px-6 py-4 rounded-t-xl">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="{{ $config['icon'] }} mr-2"></i>
                            Información del Proceso
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Estado:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $config['badge'] }}">
                                {{ $nombreProceso }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Código:</span>
                            <span class="text-gray-800 font-mono">{{ $estado }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Contratos:</span>
                            <span class="text-gray-800 font-semibold">{{ $estadisticas['total_contratos'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Valor Total:</span>
                            <span class="text-green-600 font-bold">${{ number_format($estadisticas['valor_total'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 rounded-t-xl">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-bolt mr-2"></i>
                            Acciones Rápidas
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('contratacion.contratos.create') }}" 
                           class="flex items-center w-full p-3 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-plus text-emerald-600 mr-3"></i>
                            <span class="text-emerald-700 font-medium">Crear Contrato</span>
                        </a>
                        <a href="{{ route('contratacion.contratos.index', ['estado' => $estado]) }}" 
                           class="flex items-center w-full p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-filter text-blue-600 mr-3"></i>
                            <span class="text-blue-700 font-medium">Filtrar Contratos</span>
                        </a>
                        <a href="{{ route('contratacion.proveedores.index') }}" 
                           class="flex items-center w-full p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-users text-purple-600 mr-3"></i>
                            <span class="text-purple-700 font-medium">Ver Proveedores</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Lista de Contratos en el Proceso -->
            <div class="lg:col-span-2">                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20">
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 rounded-t-xl">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-list mr-2"></i>
                            Contratos en {{ $nombreProceso }}
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($contratos->count() > 0)
                            <div class="space-y-4">
                                @foreach($contratos as $contrato)
                                <div class="bg-gray-50/50 rounded-lg p-4 hover:bg-white/80 transition-all duration-200 border border-gray-200/50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-file-contract text-purple-600"></i>                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">Contrato #{{ $contrato->id }}</h4>
                                                <p class="text-sm text-gray-600">{{ $contrato->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $contrato->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-green-600 text-lg">${{ number_format($contrato->valor, 0, ',', '.') }}</p>
                                            @if($contrato->proyecto_servicio)
                                            <p class="text-xs text-gray-500 max-w-xs truncate">{{ $contrato->proyecto_servicio }}</p>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('contratacion.contratos.show', $contrato) }}" 
                                               class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('contratacion.contratos.edit', $contrato) }}" 
                                               class="text-emerald-600 hover:text-emerald-800 transition-colors duration-200"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Paginación -->
                            @if($contratos->hasPages())
                            <div class="mt-6">
                                {{ $contratos->links() }}
                            </div>
                            @endif
                            
                            <!-- Enlace para ver todos si hay muchos -->
                            @if($contratos->total() > $contratos->perPage())
                            <div class="mt-4 text-center">
                                <a href="{{ route('contratacion.contratos.index', ['estado' => $estado]) }}" 
                                   class="text-purple-600 hover:text-purple-700 font-semibold">
                                    Ver todos los {{ $contratos->total() }} contratos <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-folder-open text-gray-400 text-5xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-500 mb-2">No hay contratos en este proceso</h3>
                                <p class="text-gray-400 mb-6">Aún no se han registrado contratos para este estado</p>
                                <a href="{{ route('contratacion.contratos.create') }}" 
                                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Crear Primer Contrato
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Análisis del Proceso -->
                @if($contratos->count() > 0)
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 mt-6">
                    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4 rounded-t-xl">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-chart-pie mr-2"></i>
                            Análisis del Proceso
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Distribución por Valor -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-4">Distribución por Valor</h4>
                                <div class="space-y-3">
                                    @php
                                        $contratosOrdenados = $contratos->sortByDesc('valor')->take(5);
                                        $valorMaximo = $contratosOrdenados->first()->valor ?? 1;
                                    @endphp
                                    @foreach($contratosOrdenados as $contrato)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-bold text-purple-600">#{{ $contrato->id }}</span>
                                            </div>
                                            <span class="text-sm text-gray-600 truncate">{{ Str::limit($contrato->user->name, 20) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" 
                                                     style="width: {{ ($contrato->valor / $valorMaximo) * 100 }}%"></div>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">${{ number_format($contrato->valor, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Cronología -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-4">Actividad Reciente</h4>
                                <div class="space-y-3">
                                    @php
                                        $contratosRecientes = $contratos->sortByDesc('created_at')->take(5);
                                    @endphp
                                    @foreach($contratosRecientes as $contrato)
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 w-2 h-2 bg-purple-600 rounded-full"></div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Contrato #{{ $contrato->id }}</p>
                                            <p class="text-xs text-gray-500">{{ $contrato->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="text-sm font-semibold text-green-600">
                                            ${{ number_format($contrato->valor, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

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
@endsection
