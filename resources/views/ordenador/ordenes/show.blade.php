@extends('layouts.app')

@section('title', 'Detalle de Orden Autorizada - Ordenador')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-file-check text-green-600 mr-3"></i>
                        Detalle de Orden Autorizada
                    </h1>
                    <p class="text-gray-600 text-lg">Orden #{{ $orden->id }} - Estado: {{ $orden->estado_formateado }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('ordenador.ordenes.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a Órdenes
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Información Principal -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Estado de la Orden -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-check-circle mr-2"></i>
                            Estado de la Orden
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-center mb-6">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-check text-green-600 text-3xl"></i>
                                </div>
                                <h4 class="text-2xl font-bold text-green-600 mb-2">{{ $orden->estado_formateado }}</h4>
                                <p class="text-gray-600">Esta orden ha sido autorizada correctamente</p>
                            </div>
                        </div>
                        
                        <!-- Timeline del proceso -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-blue-500 rounded-full mr-4"></div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">Cuenta de cobro creada</p>
                                    <p class="text-sm text-gray-500">{{ $orden->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full mr-4"></div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">Enviada para supervisión</p>
                                    <p class="text-sm text-gray-500">Proceso interno</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-green-500 rounded-full mr-4"></div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">Autorizada por Ordenador</p>
                                    <p class="text-sm text-gray-500">{{ $orden->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-purple-500 rounded-full mr-4"></div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">En proceso de pago</p>
                                    <p class="text-sm text-gray-500">Actualmente en Tesorería</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Datos de la Cuenta de Cobro -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información de la Orden
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ID de Orden</label>
                                <p class="text-lg font-semibold text-gray-900">#{{ $orden->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado Actual</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-2"></i>
                                    {{ $orden->estado_formateado }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Emisión</label>
                                <p class="text-lg text-gray-900">{{ $orden->fecha_emision->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Valor Total</label>
                                <p class="text-2xl font-bold text-green-600">${{ number_format($orden->valor, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Proyecto o Servicio</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900">{{ $orden->proyecto_servicio }}</p>
                            </div>
                        </div>

                        @if($orden->descripcion)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900">{{ $orden->descripcion }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información del Contratista -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-user mr-2"></i>
                            Información del Contratista
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600 text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">{{ $orden->user->name }}</h4>
                                <p class="text-gray-600">{{ $orden->user->email }}</p>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-id-badge mr-1"></i>
                                    Usuario ID: {{ $orden->user->id }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($orden->ruta_archivo)
                <!-- Archivo Adjunto -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-paperclip mr-2"></i>
                            Archivo Adjunto
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Documento de la Orden</p>
                                    <p class="text-sm text-gray-500">{{ basename($orden->ruta_archivo) }}</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($orden->ruta_archivo) }}" 
                               target="_blank"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300">
                                <i class="fas fa-download mr-2"></i>
                                Descargar
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Panel Lateral -->
            <div class="space-y-6">
                <!-- Resumen de la Autorización -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-chart-line mr-2"></i>
                            Resumen de Autorización
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Tiempo de autorización:</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $orden->fecha_emision->diffInDays($orden->updated_at) }} días
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Autorizado el:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $orden->updated_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Estado actual:</span>
                            <span class="text-sm font-medium text-green-600">Procesando pago</span>
                        </div>
                    </div>
                </div>

                <!-- Acciones Disponibles -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-tools mr-2"></i>
                            Acciones Disponibles
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($orden->ruta_archivo)
                        <a href="{{ Storage::url($orden->ruta_archivo) }}" 
                           target="_blank"
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center block">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Documento
                        </a>
                        @endif
                        
                        <button onclick="window.print()" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-print mr-2"></i>
                            Imprimir Detalle
                        </button>
                        
                        <a href="{{ route('ordenador.ordenes.index') }}" 
                           class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center block">
                            <i class="fas fa-list mr-2"></i>
                            Ver Todas las Órdenes
                        </a>
                    </div>
                </div>

                <!-- Información Técnica -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información Técnica
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">ID de registro:</span>
                            <span class="text-sm font-medium text-gray-900">#{{ $orden->id }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Creado el:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $orden->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Última actualización:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $orden->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Usuario ID:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $orden->user_id }}</span>
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
                        <li><i class="fas fa-check-circle mr-2 text-green-600"></i>Esta orden ya ha sido autorizada</li>
                        <li><i class="fas fa-clock mr-2 text-yellow-600"></i>Está en proceso de pago en Tesorería</li>
                        <li><i class="fas fa-info-circle mr-2 text-blue-600"></i>No requiere acciones adicionales</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Función para imprimir solo el contenido relevante
window.print = function() {
    const printContent = document.querySelector('.container').innerHTML;
    const originalContent = document.body.innerHTML;
    
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();
};

// Animaciones de entrada
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.bg-white\\/70');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection
