@extends('layouts.app')

@section('title', 'Detalle del Proveedor - Contratación')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-building text-indigo-600 mr-3"></i>
                        Detalle del Proveedor
                    </h1>
                    <p class="text-gray-600 text-lg">Información completa del proveedor</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('contratacion.proveedores.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a Proveedores
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Información Principal -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Datos del Proveedor -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-user-tie mr-2"></i>
                            Información del Proveedor
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-6 mb-6">
                            <div class="h-20 w-20 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-building text-indigo-600 text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-900">{{ $proveedor->name }}</h4>
                                <p class="text-gray-600 text-lg">{{ $proveedor->email }}</p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Activo
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Desde: {{ $proveedor->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ID de Usuario</label>
                                <p class="text-lg font-semibold text-gray-900">#{{ $proveedor->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Registro</label>
                                <p class="text-lg text-gray-900">{{ $proveedor->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Última Actividad</label>
                                <p class="text-lg text-gray-900">{{ $proveedor->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Usuario</label>
                                <p class="text-lg text-gray-900">{{ $proveedor->role->name ?? 'Sin rol' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Historial de Contratos -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-teal-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-file-contract mr-2"></i>
                            Historial de Contratos
                        </h3>
                    </div>
                    
                    @if($contratos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto/Servicio</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($contratos as $contrato)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#{{ $contrato->id }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($contrato->proyecto_servicio, 40) }}</div>
                                        @if($contrato->descripcion)
                                        <div class="text-sm text-gray-500">{{ Str::limit($contrato->descripcion, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-green-600">
                                            ${{ number_format($contrato->valor, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $colors = [
                                                'borrador' => 'bg-gray-100 text-gray-800',
                                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                'revision' => 'bg-blue-100 text-blue-800',
                                                'aprobado' => 'bg-green-100 text-green-800',
                                                'rechazado' => 'bg-red-100 text-red-800',
                                                'pagado' => 'bg-purple-100 text-purple-800',
                                            ];
                                            $colorClass = $colors[$contrato->estado] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                            {{ $contrato->estado_formateado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $contrato->fecha_emision->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('contratacion.contratos.show', $contrato->id) }}" 
                                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-xs font-semibold transition-colors duration-200">
                                            <i class="fas fa-eye mr-1"></i>
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-gray-50 px-6 py-4">
                        {{ $contratos->appends(request()->query())->links() }}
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-file-contract text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Sin contratos registrados</h3>
                        <p class="text-gray-500">Este proveedor aún no tiene contratos en el sistema.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Panel Lateral -->
            <div class="space-y-6">
                <!-- Estadísticas del Proveedor -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Estadísticas
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Contratos:</span>
                            <span class="text-lg font-bold text-indigo-600">{{ $estadisticas['total_contratos'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Valor Total:</span>
                            <span class="text-lg font-bold text-green-600">${{ number_format($estadisticas['valor_total'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Contratos Activos:</span>
                            <span class="text-lg font-bold text-orange-600">{{ $estadisticas['contratos_activos'] }}</span>
                        </div>
                        @if($estadisticas['ultimo_contrato'])
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Último Contrato:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $estadisticas['ultimo_contrato']->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-lightning-bolt mr-2"></i>
                            Acciones Rápidas
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('contratacion.contratos.create', ['proveedor_id' => $proveedor->id]) }}" 
                           class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i>
                            Nuevo Contrato
                        </a>
                        <button onclick="window.print()" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <i class="fas fa-print mr-2"></i>
                            Imprimir Información
                        </button>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información Adicional
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Tiempo como proveedor:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $proveedor->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Verificado:</span>
                            <span class="text-sm font-medium text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                Sí
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Estado:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Activo
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Ayuda -->
                <div class="bg-blue-50/70 backdrop-blur-sm rounded-xl border border-blue-200 p-6">
                    <h4 class="font-semibold text-blue-900 mb-3">
                        <i class="fas fa-question-circle mr-2"></i>
                        Información
                    </h4>
                    <ul class="text-sm text-blue-800 space-y-2">
                        <li><i class="fas fa-info-circle mr-2 text-blue-600"></i>Ver historial completo de contratos</li>
                        <li><i class="fas fa-plus-circle mr-2 text-green-600"></i>Crear nuevos contratos directamente</li>
                        <li><i class="fas fa-chart-line mr-2 text-purple-600"></i>Estadísticas en tiempo real</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

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
