@extends('layouts.app')

@section('title', 'Autorizaciones Pendientes - Ordenador')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-clipboard-check text-indigo-600 mr-3"></i>
                        Autorizaciones Pendientes
                    </h1>
                    <p class="text-gray-600 text-lg">Gestiona las cuentas de cobro que requieren autorización</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('ordenador.dashboard') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros y Estadísticas -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <!-- Estadística: Total Pendientes -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pendientes</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $autorizaciones->total() }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-full">
                        <i class="fas fa-hourglass-half text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Estadística: Valor Total -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Valor Total</p>
                        <p class="text-3xl font-bold text-green-600">${{ number_format($valorTotal, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Filtro por Usuario -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                <form method="GET" action="{{ route('ordenador.autorizaciones.index') }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Usuario</label>
                    <select name="usuario" onchange="this.form.submit()" 
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos los usuarios</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ request('usuario') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                    @if(request('usuario'))
                        <input type="hidden" name="fecha" value="{{ request('fecha') }}">
                    @endif
                </form>
            </div>

            <!-- Filtro por Fecha -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                <form method="GET" action="{{ route('ordenador.autorizaciones.index') }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Fecha</label>
                    <input type="date" name="fecha" value="{{ request('fecha') }}" 
                           onchange="this.form.submit()"
                           class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @if(request('fecha'))
                        <input type="hidden" name="usuario" value="{{ request('usuario') }}">
                    @endif
                </form>
            </div>
        </div>

        <!-- Botones de Limpiar Filtros -->
        @if(request('usuario') || request('fecha'))
        <div class="mb-6">
            <a href="{{ route('ordenador.autorizaciones.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300">
                <i class="fas fa-times mr-2"></i>
                Limpiar Filtros
            </a>
        </div>
        @endif

        <!-- Lista de Autorizaciones -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
            @if($autorizaciones->count() > 0)
                <!-- Header de la tabla -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <h3 class="text-xl font-semibold text-white">
                        <i class="fas fa-list mr-2"></i>
                        Cuentas de Cobro Pendientes de Autorización
                    </h3>
                </div>

                <!-- Tabla de autorizaciones -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contratista</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto/Servicio</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Emisión</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($autorizaciones as $autorizacion)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $autorizacion->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-indigo-600 text-sm"></i>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $autorizacion->user->name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $autorizacion->proyecto_servicio }}">
                                        {{ $autorizacion->proyecto_servicio }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                    ${{ number_format($autorizacion->valor, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $autorizacion->fecha_emision->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $autorizacion->estado_formateado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('ordenador.autorizaciones.show', $autorizacion->id) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Ver Detalle
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($autorizaciones->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $autorizaciones->appends(request()->query())->links() }}
                </div>
                @endif

            @else
                <!-- Estado vacío -->
                <div class="text-center py-12">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-check text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-500 mb-2">No hay autorizaciones pendientes</h3>
                    <p class="text-gray-400 mb-6">
                        @if(request('usuario') || request('fecha'))
                            No se encontraron autorizaciones con los filtros aplicados.
                        @else
                            Actualmente no hay cuentas de cobro pendientes de tu autorización.
                        @endif
                    </p>
                    @if(request('usuario') || request('fecha'))
                    <a href="{{ route('ordenador.autorizaciones.index') }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Limpiar Filtros
                    </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh cada 30 segundos si hay autorizaciones pendientes
    @if($autorizaciones->count() > 0)
    setInterval(function() {
        // Solo refrescar si no hay filtros aplicados para no perder el estado
        @if(!request('usuario') && !request('fecha'))
        window.location.reload();
        @endif
    }, 30000);
    @endif
});
</script>
@endsection
