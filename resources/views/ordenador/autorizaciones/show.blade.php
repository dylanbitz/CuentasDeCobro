@extends('layouts.app')

@section('title', 'Detalle de Autorización - Ordenador')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-file-invoice text-indigo-600 mr-3"></i>
                        Detalle de Autorización
                    </h1>
                    <p class="text-gray-600 text-lg">Cuenta de Cobro #{{ $autorizacion->id }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('ordenador.autorizaciones.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a Autorizaciones
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Información Principal -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Datos de la Cuenta de Cobro -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información de la Cuenta de Cobro
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ID de Cuenta</label>
                                <p class="text-lg font-semibold text-gray-900">#{{ $autorizacion->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado Actual</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $autorizacion->estado_formateado }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Emisión</label>
                                <p class="text-lg text-gray-900">{{ $autorizacion->fecha_emision->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Valor Total</label>
                                <p class="text-2xl font-bold text-green-600">${{ number_format($autorizacion->valor, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Proyecto o Servicio</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900">{{ $autorizacion->proyecto_servicio }}</p>
                            </div>
                        </div>

                        @if($autorizacion->descripcion)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900">{{ $autorizacion->descripcion }}</p>
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
                                <h4 class="text-xl font-semibold text-gray-900">{{ $autorizacion->user->name }}</h4>
                                <p class="text-gray-600">{{ $autorizacion->user->email }}</p>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-id-badge mr-1"></i>
                                    Usuario ID: {{ $autorizacion->user->id }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($autorizacion->ruta_archivo)
                <!-- Archivo Adjunto -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
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
                                    <p class="font-medium text-gray-900">Documento de la Cuenta de Cobro</p>
                                    <p class="text-sm text-gray-500">{{ basename($autorizacion->ruta_archivo) }}</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($autorizacion->ruta_archivo) }}" 
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

            <!-- Panel de Acciones -->
            <div class="space-y-6">
                <!-- Acciones de Autorización -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-tasks mr-2"></i>
                            Acciones de Autorización
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Formulario de Autorización -->
                        <form id="autorizacionForm" method="POST" action="{{ route('ordenador.autorizaciones.autorizar', $autorizacion->id) }}">
                            @csrf
                            
                            <!-- Campo de observaciones -->
                            <div class="mb-4">
                                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                                    Observaciones (Opcional)
                                </label>
                                <textarea id="observaciones" name="observaciones" rows="4" 
                                         class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                         placeholder="Ingresa observaciones sobre esta autorización..."></textarea>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="space-y-3">
                                <!-- Botón Autorizar -->
                                <button type="button" onclick="confirmarAccion('autorizar')"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-check mr-2"></i>
                                    Autorizar Cuenta de Cobro
                                </button>

                                <!-- Botón Rechazar -->
                                <button type="button" onclick="confirmarAccion('rechazar')"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-times mr-2"></i>
                                    Rechazar Cuenta de Cobro
                                </button>
                            </div>

                            <!-- Campo oculto para la acción -->
                            <input type="hidden" id="accion" name="accion" value="">
                        </form>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información Adicional
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Creado el:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $autorizacion->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Última actualización:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $autorizacion->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Días desde emisión:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $autorizacion->fecha_emision->diffInDays(now()) }} días</span>
                        </div>
                    </div>
                </div>

                <!-- Ayuda -->
                <div class="bg-blue-50/70 backdrop-blur-sm rounded-xl border border-blue-200 p-6">
                    <h4 class="font-semibold text-blue-900 mb-3">
                        <i class="fas fa-question-circle mr-2"></i>
                        ¿Necesitas ayuda?
                    </h4>
                    <ul class="text-sm text-blue-800 space-y-2">
                        <li><i class="fas fa-check-circle mr-2 text-green-600"></i>Autorizar: Permite que la cuenta pase a Tesorería</li>
                        <li><i class="fas fa-times-circle mr-2 text-red-600"></i>Rechazar: Devuelve la cuenta al contratista</li>
                        <li><i class="fas fa-edit mr-2 text-blue-600"></i>Las observaciones son opcionales pero recomendadas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md mx-4 shadow-2xl">
        <div class="text-center">
            <div id="modalIcon" class="mx-auto mb-4 w-16 h-16 rounded-full flex items-center justify-center">
                <!-- Icono dinámico -->
            </div>
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-900 mb-2"></h3>
            <p id="modalMessage" class="text-gray-600 mb-6"></p>
            <div class="flex space-x-4">
                <button onclick="cerrarModal()" 
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-semibold transition-colors duration-200">
                    Cancelar
                </button>
                <button onclick="ejecutarAccion()" 
                        id="confirmButton"
                        class="flex-1 px-4 py-2 rounded-lg font-semibold transition-colors duration-200">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
let accionPendiente = '';

function confirmarAccion(accion) {
    accionPendiente = accion;
    const modal = document.getElementById('confirmModal');
    const modalIcon = document.getElementById('modalIcon');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const confirmButton = document.getElementById('confirmButton');

    if (accion === 'autorizar') {
        modalIcon.innerHTML = '<i class="fas fa-check text-4xl text-green-600"></i>';
        modalIcon.className = 'mx-auto mb-4 w-16 h-16 bg-green-100 rounded-full flex items-center justify-center';
        modalTitle.textContent = 'Confirmar Autorización';
        modalMessage.textContent = '¿Estás seguro de que deseas autorizar esta cuenta de cobro? Esta acción enviará el documento a Tesorería para su pago.';
        confirmButton.className = 'flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-200';
        confirmButton.textContent = 'Autorizar';
    } else {
        modalIcon.innerHTML = '<i class="fas fa-times text-4xl text-red-600"></i>';
        modalIcon.className = 'mx-auto mb-4 w-16 h-16 bg-red-100 rounded-full flex items-center justify-center';
        modalTitle.textContent = 'Confirmar Rechazo';
        modalMessage.textContent = '¿Estás seguro de que deseas rechazar esta cuenta de cobro? Esta acción devolverá el documento al contratista.';
        confirmButton.className = 'flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-200';
        confirmButton.textContent = 'Rechazar';
    }

    modal.classList.remove('hidden');
}

function cerrarModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

function ejecutarAccion() {
    document.getElementById('accion').value = accionPendiente;
    document.getElementById('autorizacionForm').submit();
}

// Cerrar modal con ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        cerrarModal();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('confirmModal').addEventListener('click', function(event) {
    if (event.target === this) {
        cerrarModal();
    }
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
