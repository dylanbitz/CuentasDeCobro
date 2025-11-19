@extends('layouts.app')

@section('title', 'Crear Nuevo Contrato - Contratación')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('contratacion.dashboard') }}" class="text-gray-700 hover:text-emerald-600 inline-flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('contratacion.contratos.index') }}" class="text-gray-700 hover:text-emerald-600">Contratos</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Crear Nuevo</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-8">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                    <div class="mb-6 lg:mb-0">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-4 rounded-2xl shadow-lg mr-4">
                                <i class="fas fa-plus-circle text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    Crear Nuevo Contrato
                                </h1>
                                <p class="text-gray-600 text-lg mt-1">Registra un nuevo contrato en el sistema</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-emerald-500 mr-2"></i>
                                Completa todos los campos obligatorios
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-save text-emerald-500 mr-2"></i>
                                Guarda tu progreso automáticamente
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('contratacion.contratos.index') }}" 
                           class="bg-white/70 hover:bg-white text-gray-700 border-2 border-gray-200 hover:border-gray-300 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>        <!-- Formulario Principal -->
        <div class="max-w-6xl mx-auto">
            <form method="POST" action="{{ route('contratacion.contratos.store') }}" enctype="multipart/form-data" id="contratoForm">
                @csrf
                
                <!-- Información del Proveedor -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 mb-8 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-user-tie mr-3"></i>
                            Información del Proveedor
                        </h3>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Selección de Proveedor -->
                            <div class="lg:col-span-2">
                                <label for="user_id" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-user mr-2 text-emerald-500"></i>
                                    Contratista/Proveedor *
                                </label>
                                <div class="relative">
                                    <select id="user_id" name="user_id" required
                                            class="w-full p-4 pr-12 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 @error('user_id') border-red-500 @enderror">                                        <option value="">🔍 Seleccione un contratista...</option>
                                        @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}" {{ old('user_id') == $proveedor->id ? 'selected' : '' }}>
                                            👤 {{ $proveedor->name }} - {{ $proveedor->email }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('user_id')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-gray-500 text-sm mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Selecciona el proveedor responsable del contrato
                                </p>
                            </div>
                            
                            <!-- Información del Proveedor Seleccionado -->
                            <div id="proveedorInfo" class="lg:col-span-2 bg-gray-50 rounded-xl p-6 hidden">
                                <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-info-circle text-emerald-500 mr-2"></i>
                                    Información del Proveedor
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="proveedorDetails">
                                    <!-- Se llenará dinámicamente -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalles del Contrato -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 mb-8 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-file-contract mr-3"></i>
                            Detalles del Contrato
                        </h3>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Concepto/Proyecto -->
                            <div class="lg:col-span-2">
                                <label for="concepto" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-project-diagram mr-2 text-blue-500"></i>
                                    Concepto del Contrato *
                                </label>
                                <input type="text" id="concepto" name="concepto" required
                                       value="{{ old('concepto') }}"
                                       class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('concepto') border-red-500 @enderror"
                                       placeholder="Ej: Desarrollo de Sistema de Gestión Municipal">
                                @error('concepto')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Descripción Detallada -->
                            <div class="lg:col-span-2">
                                <label for="descripcion" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-align-left mr-2 text-blue-500"></i>
                                    Descripción Detallada
                                </label>
                                <textarea id="descripcion" name="descripcion" rows="6"
                                          class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 resize-none @error('descripcion') border-red-500 @enderror"
                                          placeholder="Describe detalladamente el alcance, objetivos y especificaciones del contrato...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-gray-500 text-sm mt-2">
                                    <i class="fas fa-lightbulb mr-1"></i>
                                    Incluye objetivos, alcance, entregables y especificaciones técnicas
                                </p>
                            </div>

                            <!-- Valor del Contrato -->
                            <div>
                                <label for="valor" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-dollar-sign mr-2 text-green-500"></i>
                                    Valor del Contrato *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">$</span>
                                    <input type="number" id="valor" name="valor" step="0.01" min="0" required
                                           value="{{ old('valor') }}"
                                           class="w-full pl-8 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 @error('valor') border-red-500 @enderror font-semibold text-lg"
                                           placeholder="0.00">
                                </div>
                                @error('valor')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-gray-500 text-sm mt-2">
                                    <i class="fas fa-calculator mr-1"></i>
                                    Ingresa el valor total sin puntos ni comas
                                </p>
                            </div>

                            <!-- Estado del Contrato -->
                            <div>
                                <label for="estado" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-flag mr-2 text-purple-500"></i>
                                    Estado del Contrato
                                </label>
                                <select id="estado" name="estado"
                                        class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300">
                                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>
                                        ⏳ Pendiente
                                    </option>
                                    <option value="aprobado" {{ old('estado') == 'aprobado' ? 'selected' : '' }}>
                                        ✅ Aprobado
                                    </option>
                                    <option value="en_proceso" {{ old('estado') == 'en_proceso' ? 'selected' : '' }}>
                                        🔄 En Proceso
                                    </option>
                                    <option value="completado" {{ old('estado') == 'completado' ? 'selected' : '' }}>
                                        ✔️ Completado
                                    </option>
                                </select>
                                <p class="text-gray-500 text-sm mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    El estado inicial será "Pendiente" por defecto
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fechas y Duración -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 mb-8 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Cronograma del Contrato
                        </h3>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Fecha de Inicio -->
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-play-circle mr-2 text-green-500"></i>
                                    Fecha de Inicio
                                </label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio"
                                       value="{{ old('fecha_inicio', now()->format('Y-m-d')) }}"
                                       class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300">
                            </div>

                            <!-- Fecha de Fin -->
                            <div>
                                <label for="fecha_fin" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-stop-circle mr-2 text-red-500"></i>
                                    Fecha de Finalización
                                </label>
                                <input type="date" id="fecha_fin" name="fecha_fin"
                                       value="{{ old('fecha_fin') }}"
                                       class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all duration-300">
                            </div>

                            <!-- Duración Estimada -->
                            <div>
                                <label for="duracion_dias" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-hourglass-half mr-2 text-blue-500"></i>
                                    Duración (días)
                                </label>
                                <input type="number" id="duracion_dias" name="duracion_dias" min="1"
                                       value="{{ old('duracion_dias') }}"
                                       class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300"
                                       placeholder="30" readonly>
                                <p class="text-gray-500 text-sm mt-2">
                                    <i class="fas fa-magic mr-1"></i>
                                    Se calcula automáticamente
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documentos y Archivos -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 mb-8 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-file-upload mr-3"></i>
                            Documentos del Contrato
                        </h3>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Subir Archivo -->
                            <div>
                                <label for="archivo" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-paperclip mr-2 text-orange-500"></i>
                                    Documento del Contrato
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-orange-500 transition-colors duration-300">
                                    <input type="file" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.txt"
                                           class="hidden" onchange="handleFileSelect(this)">
                                    <label for="archivo" class="cursor-pointer">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-4"></i>
                                            <p class="text-gray-600 font-semibold mb-2">
                                                Haz clic aquí o arrastra archivos
                                            </p>
                                            <p class="text-gray-500 text-sm">
                                                Formatos: PDF, DOC, DOCX, TXT (Máx. 10MB)
                                            </p>
                                        </div>
                                    </label>
                                </div>
                                <div id="file-info" class="mt-4 hidden">
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-file text-orange-500 mr-3"></i>
                                            <span id="file-name" class="font-medium text-orange-800"></span>
                                            <button type="button" onclick="removeFile()" class="ml-auto text-orange-600 hover:text-orange-800">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-shield-alt text-emerald-500 mr-2"></i>
                            Todos los datos están protegidos y encriptados
                        </div>
                        
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('contratacion.contratos.index') }}" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>
                            
                            <button type="button" onclick="saveDraft()" 
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-save mr-2"></i>
                                Guardar Borrador
                            </button>
                            
                            <button type="submit" 
                                    class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-12 py-4 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-xl">
                                <i class="fas fa-check-circle mr-2"></i>
                                Crear Contrato
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Cálculo automático de duración
document.getElementById('fecha_inicio').addEventListener('change', calculateDuration);
document.getElementById('fecha_fin').addEventListener('change', calculateDuration);

function calculateDuration() {
    const fechaInicio = document.getElementById('fecha_inicio').value;
    const fechaFin = document.getElementById('fecha_fin').value;
    
    if (fechaInicio && fechaFin) {
        const inicio = new Date(fechaInicio);
        const fin = new Date(fechaFin);
        const diffTime = Math.abs(fin - inicio);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        document.getElementById('duracion_dias').value = diffDays;
    }
}

// Manejo de archivos
function handleFileSelect(input) {
    const file = input.files[0];
    if (file) {
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-info').classList.remove('hidden');
    }
}

function removeFile() {
    document.getElementById('archivo').value = '';
    document.getElementById('file-info').classList.add('hidden');
}

// Guardar borrador
function saveDraft() {
    // Implementar lógica de guardado de borrador
    Swal.fire({
        icon: 'info',
        title: 'Borrador guardado',
        text: 'El borrador del contrato ha sido guardado exitosamente',
        timer: 2000,
        showConfirmButton: false
    });
}

// Información del proveedor
document.getElementById('user_id').addEventListener('change', function() {
    const proveedorId = this.value;
    if (proveedorId) {
        // Mostrar información del proveedor (implementar con AJAX si es necesario)
        document.getElementById('proveedorInfo').classList.remove('hidden');
    } else {
        document.getElementById('proveedorInfo').classList.add('hidden');
    }
});

// Validación de formulario
document.getElementById('contratoForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: '¿Confirmar creación?',
        text: 'Se creará un nuevo contrato con la información proporcionada',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Sí, crear contrato',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>

<!-- CSS personalizado para animaciones -->
<style>
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
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.form-section {
    opacity: 0;
    animation: fadeInUp 0.6s ease-out forwards;
}

.form-section:nth-child(1) { animation-delay: 0.1s; }
.form-section:nth-child(2) { animation-delay: 0.2s; }
.form-section:nth-child(3) { animation-delay: 0.3s; }
.form-section:nth-child(4) { animation-delay: 0.4s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

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

                        <!-- Fecha de Emisión -->
                        <div>
                            <label for="fecha_emision" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                Fecha de Emisión *
                            </label>
                            <input type="date" id="fecha_emision" name="fecha_emision" 
                                   value="{{ old('fecha_emision', date('Y-m-d')) }}"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('fecha_emision') border-red-500 @enderror">
                            @error('fecha_emision')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-flag mr-1"></i>
                                Estado Inicial *
                            </label>
                            <select id="estado" name="estado" 
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('estado') border-red-500 @enderror">
                                @foreach($estados as $key => $nombre)
                                <option value="{{ $key }}" {{ old('estado', 'borrador') == $key ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                                @endforeach
                            </select>
                            @error('estado')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Archivo -->
                        <div>
                            <label for="archivo" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-paperclip mr-1"></i>
                                Documento del Contrato
                            </label>
                            <input type="file" id="archivo" name="archivo" accept=".pdf,.doc,.docx"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('archivo') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Archivos permitidos: PDF, DOC, DOCX (máximo 10MB)</p>
                            @error('archivo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="mt-8 p-6 bg-blue-50 rounded-lg border border-blue-200">
                        <h4 class="font-semibold text-blue-900 mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información Importante
                        </h4>
                        <ul class="text-sm text-blue-800 space-y-2">
                            <li><i class="fas fa-check-circle mr-2 text-green-600"></i>Todos los campos marcados con (*) son obligatorios</li>
                            <li><i class="fas fa-user mr-2 text-blue-600"></i>Solo se pueden asignar contratos a usuarios con rol de contratista</li>
                            <li><i class="fas fa-file mr-2 text-purple-600"></i>Los documentos se almacenan de forma segura en el servidor</li>
                            <li><i class="fas fa-edit mr-2 text-orange-600"></i>Podrás editar esta información después de crear el contrato</li>
                        </ul>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('contratacion.contratos.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-save mr-2"></i>
                            Crear Contrato
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para mejorar UX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formatear valor mientras se escribe
    const valorInput = document.getElementById('valor');
    valorInput.addEventListener('input', function() {
        let value = this.value.replace(/[^\d.]/g, '');
        if (value.split('.').length > 2) {
            value = value.substring(0, value.lastIndexOf('.'));
        }
        this.value = value;
    });

    // Auto-completar fecha actual si está vacía
    const fechaInput = document.getElementById('fecha_emision');
    if (!fechaInput.value) {
        fechaInput.value = new Date().toISOString().split('T')[0];
    }

    // Validar archivo antes de enviar
    const archivoInput = document.getElementById('archivo');
    archivoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const maxSize = 10 * 1024 * 1024; // 10MB
            if (file.size > maxSize) {
                alert('El archivo es demasiado grande. El tamaño máximo permitido es 10MB.');
                this.value = '';
                return;
            }
            
            const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!allowedTypes.includes(file.type)) {
                alert('Tipo de archivo no permitido. Solo se aceptan archivos PDF, DOC y DOCX.');
                this.value = '';
                return;
            }
        }
    });
});
</script>

<!-- SweetAlert para errores -->
@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function() {
    let errores = '';
    @foreach($errors->all() as $error)
        errores += '• {{ $error }}\n';
    @endforeach
    
    Swal.fire({
        icon: 'error',
        title: 'Errores en el formulario',
        text: errores,
        confirmButtonText: 'Corregir'
    });
});
</script>
@endif
@endsection
