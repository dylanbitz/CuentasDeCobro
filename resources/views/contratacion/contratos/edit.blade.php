@extends('layouts.app')

@section('title', 'Editar Contrato - Contratación')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden">
    <!-- Background Animation -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-cyan-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
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
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('contratacion.contratos.show', $contrato->id) }}" class="text-gray-700 hover:text-emerald-600">Contrato #{{ $contrato->id }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Editar</span>
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
                                <i class="fas fa-edit text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    Editar Contrato #{{ str_pad($contrato->id, 6, '0', STR_PAD_LEFT) }}
                                </h1>
                                <p class="text-gray-600 text-lg mt-1">Actualiza la información del contrato</p>
                            </div>
                        </div>
                        
                        <!-- Estado del Contrato -->
                        <div class="flex items-center space-x-4">
                            @php
                                $estadoConfig = [
                                    'pendiente' => ['bg-yellow-100 text-yellow-800', 'fas fa-clock', 'Pendiente'],
                                    'aprobado' => ['bg-green-100 text-green-800', 'fas fa-check-circle', 'Aprobado'],
                                    'rechazado' => ['bg-red-100 text-red-800', 'fas fa-times-circle', 'Rechazado'],
                                    'en_proceso' => ['bg-blue-100 text-blue-800', 'fas fa-cogs', 'En Proceso'],
                                    'completado' => ['bg-purple-100 text-purple-800', 'fas fa-flag-checkered', 'Completado']
                                ];
                                $estado = $contrato->estado ?? 'pendiente';
                                $config = $estadoConfig[$estado] ?? $estadoConfig['pendiente'];
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $config[0] }}">
                                <i class="{{ $config[1] }} mr-2"></i>
                                Estado Actual: {{ $config[2] }}
                            </span>
                            <span class="text-gray-500 text-sm">
                                <i class="fas fa-calendar mr-1"></i>
                                Última actualización: {{ $contrato->updated_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('contratacion.contratos.show', $contrato->id) }}" 
                           class="bg-blue-100 hover:bg-blue-200 text-blue-700 border-2 border-blue-200 hover:border-blue-300 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            <i class="fas fa-eye mr-2"></i>
                            Ver Contrato
                        </a>
                        <a href="{{ route('contratacion.contratos.index') }}" 
                           class="bg-white/70 hover:bg-white text-gray-700 border-2 border-gray-200 hover:border-gray-300 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Volver a Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('contratacion.contratos.update', $contrato->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  id="editContractForm">
                @csrf
                @method('PUT')
                
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-8 flex items-center">
                        <i class="fas fa-edit mr-3 text-blue-300"></i>
                        Información del Contrato
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Proveedor -->
                        <div class="md:col-span-1">
                            <label for="user_id" class="block text-white font-medium mb-2">
                                Proveedor <span class="text-red-400">*</span>
                            </label>
                            <select name="user_id" 
                                    id="user_id" 
                                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="">Seleccionar proveedor...</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}" 
                                            {{ old('user_id', $contrato->user_id) == $proveedor->id ? 'selected' : '' }}
                                            class="bg-gray-800 text-white">
                                        {{ $proveedor->name }} - {{ $proveedor->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>                        <!-- Concepto -->
                        <div class="md:col-span-1">
                            <label for="concepto" class="block text-white font-medium mb-2">
                                Concepto <span class="text-red-400">*</span>
                            </label>
                            <input type="text" 
                                   name="concepto" 
                                   id="concepto" 
                                   value="{{ old('concepto', $contrato->concepto) }}"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300" 
                                   placeholder="Descripción del servicio o producto"
                                   required>
                            @error('concepto')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Valor -->
                        <div class="md:col-span-1">
                            <label for="valor" class="block text-white font-medium mb-2">
                                Valor Total <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-gray-300">$</span>
                                <input type="number" 
                                       name="valor" 
                                       id="valor" 
                                       value="{{ old('valor', $contrato->valor) }}"
                                       class="w-full bg-white/10 border border-white/20 rounded-lg pl-8 pr-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300" 
                                       placeholder="0"
                                       min="0"
                                       step="0.01"
                                       required>
                            </div>
                            @error('valor')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="md:col-span-1">
                            <label for="estado" class="block text-white font-medium mb-2">
                                Estado del Contrato <span class="text-red-400">*</span>
                            </label>                            <select name="estado" 
                                    id="estado" 
                                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300"
                                    required>
                                @foreach($estados as $key => $nombre)
                                    <option value="{{ $key }}" {{ old('estado', $contrato->estado) == $key ? 'selected' : '' }} class="bg-gray-800 text-white">{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('estado')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Fechas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="md:col-span-1">
                            <label for="fecha_inicio" class="block text-white font-medium mb-2">
                                Fecha de Inicio <span class="text-red-400">*</span>
                            </label>
                            <input type="date" 
                                   name="fecha_inicio" 
                                   id="fecha_inicio" 
                                   value="{{ old('fecha_inicio', $contrato->fecha_inicio ? $contrato->fecha_inicio->format('Y-m-d') : '') }}"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300"
                                   required>
                            @error('fecha_inicio')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-1">
                            <label for="fecha_fin" class="block text-white font-medium mb-2">
                                Fecha de Finalización
                            </label>
                            <input type="date" 
                                   name="fecha_fin" 
                                   id="fecha_fin" 
                                   value="{{ old('fecha_fin', $contrato->fecha_fin ? $contrato->fecha_fin->format('Y-m-d') : '') }}"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300">
                            @error('fecha_fin')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-8">
                        <label for="descripcion" class="block text-white font-medium mb-2">
                            Descripción Detallada
                        </label>
                        <textarea name="descripcion" 
                                  id="descripcion" 
                                  rows="4"
                                  class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300 resize-none"
                                  placeholder="Describe en detalle el contrato, términos, condiciones especiales, etc.">{{ old('descripcion', $contrato->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="mb-8">
                        <label for="observaciones" class="block text-white font-medium mb-2">
                            Observaciones Adicionales
                        </label>
                        <textarea name="observaciones" 
                                  id="observaciones" 
                                  rows="3"
                                  class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300 resize-none"
                                  placeholder="Notas adicionales, comentarios del equipo, etc.">{{ old('observaciones', $contrato->observaciones) }}</textarea>
                        @error('observaciones')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Archivos -->
                    <div class="mb-8">
                        <label class="block text-white font-medium mb-4">
                            <i class="fas fa-paperclip mr-2"></i>
                            Archivos del Contrato
                        </label>
                        
                        @if($contrato->archivo_cuenta_cobro)
                        <div class="mb-4 p-4 bg-white/5 rounded-lg border border-white/10">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-400 text-xl"></i>
                                    <div>
                                        <p class="text-white font-medium">Archivo Actual</p>
                                        <p class="text-gray-300 text-sm">{{ basename($contrato->archivo_cuenta_cobro) }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ Storage::url($contrato->archivo_cuenta_cobro) }}" 
                                       target="_blank"
                                       class="text-emerald-400 hover:text-emerald-300 transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ Storage::url($contrato->archivo_cuenta_cobro) }}" 
                                       download
                                       class="text-blue-400 hover:text-blue-300 transition-colors">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="relative">
                            <input type="file" 
                                   name="archivo_cuenta_cobro" 
                                   id="archivo_cuenta_cobro" 
                                   class="hidden"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <div id="dropZone" 
                                 class="border-2 border-dashed border-white/30 rounded-lg p-8 text-center cursor-pointer hover:border-emerald-400 hover:bg-white/5 transition-all duration-300">
                                <div id="dropZoneContent">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-white font-medium mb-2">
                                        {{ $contrato->archivo_cuenta_cobro ? 'Cambiar archivo' : 'Subir nuevo archivo' }}
                                    </p>
                                    <p class="text-gray-300 text-sm">
                                        Arrastra y suelta o <span class="text-emerald-400">haz clic para seleccionar</span>
                                    </p>
                                    <p class="text-gray-400 text-xs mt-2">
                                        PDF, DOC, DOCX, JPG, PNG (Máx. 10MB)
                                    </p>
                                </div>
                            </div>
                        </div>
                        @error('archivo_cuenta_cobro')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-white/20">
                        <button type="button" 
                                onclick="saveDraft()"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Borrador
                        </button>
                        
                        <a href="{{ route('contratacion.contratos.show', $contrato->id) }}" 
                           class="bg-white/10 hover:bg-white/20 text-white border-2 border-white/20 hover:border-white/40 px-8 py-3 rounded-xl font-semibold transition-all duration-300 text-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                        
                        <button type="submit" 
                                id="submitBtn"
                                class="bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-check mr-2"></i>
                            Actualizar Contrato
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeFormEnhancements();
    setupFileUpload();
    setupFormValidation();
});

// Configurar mejoras del formulario
function initializeFormEnhancements() {
    // Auto-cálculo de duración
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');
    
    if (fechaInicio && fechaFin) {
        [fechaInicio, fechaFin].forEach(input => {
            input.addEventListener('change', function() {
                calculateDuration();
            });
        });
    }

    // Formato de valor
    const valorInput = document.getElementById('valor');
    if (valorInput) {
        valorInput.addEventListener('input', function() {
            formatCurrency(this);
        });
    }
}

// Configurar subida de archivos
function setupFileUpload() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('archivo_cuenta_cobro');
    
    if (!dropZone || !fileInput) return;

    // Click en zona de drop
    dropZone.addEventListener('click', () => fileInput.click());

    // Drag & Drop
    dropZone.addEventListener('dragover', handleDragOver);
    dropZone.addEventListener('drop', handleDrop);
    dropZone.addEventListener('dragleave', handleDragLeave);

    // Cambio de archivo
    fileInput.addEventListener('change', handleFileSelect);
}

function handleDragOver(e) {
    e.preventDefault();
    e.currentTarget.classList.add('border-emerald-400', 'bg-white/10');
}

function handleDragLeave(e) {
    e.preventDefault();
    e.currentTarget.classList.remove('border-emerald-400', 'bg-white/10');
}

function handleDrop(e) {
    e.preventDefault();
    const dropZone = e.currentTarget;
    dropZone.classList.remove('border-emerald-400', 'bg-white/10');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('archivo_cuenta_cobro').files = files;
        handleFileSelect({ target: { files: files } });
    }
}

function handleFileSelect(e) {
    const file = e.target.files[0];
    if (!file) return;

    const dropZoneContent = document.getElementById('dropZoneContent');
    const maxSize = 10 * 1024 * 1024; // 10MB

    if (file.size > maxSize) {
        Swal.fire({
            icon: 'error',
            title: 'Archivo muy grande',
            text: 'El archivo no puede superar los 10MB',
            confirmButtonColor: '#059669'
        });
        return;
    }

    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        Swal.fire({
            icon: 'error',
            title: 'Tipo de archivo no válido',
            text: 'Solo se permiten archivos PDF, DOC, DOCX, JPG y PNG',
            confirmButtonColor: '#059669'
        });
        return;
    }

    // Mostrar archivo seleccionado
    dropZoneContent.innerHTML = `
        <i class="fas fa-file-check text-4xl text-emerald-400 mb-4"></i>
        <p class="text-white font-medium mb-2">Archivo seleccionado</p>
        <p class="text-emerald-400 text-sm">${file.name}</p>
        <p class="text-gray-400 text-xs mt-2">${formatFileSize(file.size)}</p>
    `;
}

// Configurar validación del formulario
function setupFormValidation() {
    const form = document.getElementById('editContractForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            Swal.fire({
                title: '¿Actualizar contrato?',
                text: 'Se actualizará la información del contrato',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    const submitBtn = document.getElementById('submitBtn');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Actualizando...';
                        submitBtn.disabled = true;
                    }
                    
                    form.submit();
                }
            });
        }
    });
}

// Validar formulario
function validateForm() {
    const requiredFields = ['user_id', 'concepto', 'valor', 'estado', 'fecha_inicio'];
    let isValid = true;

    requiredFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field && !field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else if (field) {
            field.classList.remove('border-red-500');
        }
    });

    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Campos requeridos',
            text: 'Por favor completa todos los campos obligatorios',
            confirmButtonColor: '#059669'
        });
    }

    return isValid;
}

// Calcular duración del contrato
function calculateDuration() {
    const fechaInicio = document.getElementById('fecha_inicio').value;
    const fechaFin = document.getElementById('fecha_fin').value;
    
    if (fechaInicio && fechaFin) {
        const inicio = new Date(fechaInicio);
        const fin = new Date(fechaFin);
        const diferencia = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));
        
        if (diferencia > 0) {
            // Mostrar duración (opcional - se puede agregar un campo visual)
            console.log(`Duración: ${diferencia} días`);
        }
    }
}

// Formatear moneda
function formatCurrency(input) {
    let value = input.value.replace(/[^\d]/g, '');
    if (value) {
        input.value = parseInt(value).toLocaleString();
    }
}

// Formatear tamaño de archivo
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Guardar borrador
function saveDraft() {
    Swal.fire({
        title: 'Función en desarrollo',
        text: 'La funcionalidad de guardar borrador estará disponible próximamente',
        icon: 'info',
        confirmButtonColor: '#059669'
    });
}

// Notificaciones
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: '¡Éxito!',
    text: '{{ session("success") }}',
    confirmButtonColor: '#059669'
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '{{ session("error") }}',
    confirmButtonColor: '#059669'
});
@endif
</script>

<!-- Estilos adicionales -->
<style>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
                                   required>
                            @error('concepto')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valor -->
                        <div class="md:col-span-1">
                            <label for="valor" class="block text-white font-medium mb-2">
                                Valor ($) <span class="text-red-400">*</span>
                            </label>
                            <input type="number" 
                                   name="valor" 
                                   id="valor" 
                                   value="{{ old('valor', $contrato->valor) }}"
                                   min="0" 
                                   step="0.01"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="0.00"
                                   required>
                            @error('valor')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="md:col-span-1">
                            <label for="estado" class="block text-white font-medium mb-2">
                                Estado <span class="text-red-400">*</span>
                            </label>
                            <select name="estado" 
                                    id="estado" 
                                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="pendiente" {{ old('estado', $contrato->estado) == 'pendiente' ? 'selected' : '' }} class="bg-gray-800 text-white">Pendiente</option>
                                <option value="revision" {{ old('estado', $contrato->estado) == 'revision' ? 'selected' : '' }} class="bg-gray-800 text-white">En Revisión</option>
                                <option value="aprobado" {{ old('estado', $contrato->estado) == 'aprobado' ? 'selected' : '' }} class="bg-gray-800 text-white">Aprobado</option>
                                <option value="pagado" {{ old('estado', $contrato->estado) == 'pagado' ? 'selected' : '' }} class="bg-gray-800 text-white">Pagado</option>
                                <option value="rechazado" {{ old('estado', $contrato->estado) == 'rechazado' ? 'selected' : '' }} class="bg-gray-800 text-white">Rechazado</option>
                            </select>
                            @error('estado')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Pago (solo si el estado es pagado) -->
                        <div class="md:col-span-1" id="fechaPagoContainer" style="display: {{ old('estado', $contrato->estado) == 'pagado' ? 'block' : 'none' }}">
                            <label for="fecha_pago" class="block text-white font-medium mb-2">
                                Fecha de Pago
                            </label>
                            <input type="date" 
                                   name="fecha_pago" 
                                   id="fecha_pago" 
                                   value="{{ old('fecha_pago', $contrato->fecha_pago ? \Carbon\Carbon::parse($contrato->fecha_pago)->format('Y-m-d') : '') }}"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('fecha_pago')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="mb-8">
                        <label for="observaciones" class="block text-white font-medium mb-2">
                            Observaciones
                        </label>
                        <textarea name="observaciones" 
                                  id="observaciones" 
                                  rows="4"
                                  class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                  placeholder="Observaciones adicionales sobre el contrato...">{{ old('observaciones', $contrato->observaciones) }}</textarea>
                        @error('observaciones')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Archivo Actual -->
                    @if($contrato->archivo_cuenta_cobro)
                    <div class="mb-6">
                        <label class="block text-white font-medium mb-2">Archivo Actual</label>
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-file-pdf text-red-400 text-xl"></i>
                                <div>
                                    <p class="text-white font-medium">Cuenta de Cobro Actual</p>
                                    <p class="text-blue-200 text-sm">PDF - Subido el {{ $contrato->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($contrato->archivo_cuenta_cobro) }}" 
                               target="_blank" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-eye mr-2"></i>Ver
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Nuevo Archivo -->
                    <div class="mb-8">
                        <label for="archivo_cuenta_cobro" class="block text-white font-medium mb-2">
                            {{ $contrato->archivo_cuenta_cobro ? 'Reemplazar Archivo' : 'Subir Archivo' }}
                        </label>
                        <div class="border-2 border-dashed border-white/20 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                            <input type="file" 
                                   name="archivo_cuenta_cobro" 
                                   id="archivo_cuenta_cobro" 
                                   accept=".pdf"
                                   class="hidden">
                            <label for="archivo_cuenta_cobro" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-blue-300 mb-4"></i>
                                <p class="text-white font-medium mb-2">
                                    {{ $contrato->archivo_cuenta_cobro ? 'Seleccionar nuevo archivo PDF' : 'Seleccionar archivo PDF' }}
                                </p>
                                <p class="text-blue-200 text-sm">O arrastra y suelta el archivo aquí</p>
                                <p class="text-blue-200 text-xs mt-2">Máximo 10MB - Solo archivos PDF</p>
                            </label>
                            <div id="file-info" class="mt-4 hidden">
                                <p class="text-white font-medium" id="file-name"></p>
                                <p class="text-blue-200 text-sm" id="file-size"></p>
                            </div>
                        </div>
                        @error('archivo_cuenta_cobro')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('contratacion.contratos.show', $contrato->id) }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white py-3 px-8 rounded-lg transition-colors text-center">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg transition-colors">
                            <i class="fas fa-save mr-2"></i>Actualizar Contrato
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Estado change handler
    const estadoSelect = document.getElementById('estado');
    const fechaPagoContainer = document.getElementById('fechaPagoContainer');
    const fechaPagoInput = document.getElementById('fecha_pago');

    estadoSelect.addEventListener('change', function() {
        if (this.value === 'pagado') {
            fechaPagoContainer.style.display = 'block';
            fechaPagoInput.required = true;
            if (!fechaPagoInput.value) {
                fechaPagoInput.value = new Date().toISOString().split('T')[0];
            }
        } else {
            fechaPagoContainer.style.display = 'none';
            fechaPagoInput.required = false;
            fechaPagoInput.value = '';
        }
    });

    // File upload handler
    const fileInput = document.getElementById('archivo_cuenta_cobro');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileName.textContent = file.name;
            fileSize.textContent = `${(file.size / 1024 / 1024).toFixed(2)} MB`;
            fileInfo.classList.remove('hidden');
        } else {
            fileInfo.classList.add('hidden');
        }
    });

    // Drag & drop functionality
    const dropZone = document.querySelector('.border-dashed');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    dropZone.addEventListener('drop', handleDrop, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        dropZone.classList.add('border-blue-400', 'bg-blue-500/10');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-blue-400', 'bg-blue-500/10');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    }

    // Form validation
    document.getElementById('editContractForm').addEventListener('submit', function(e) {
        const valor = document.getElementById('valor').value;
        const concepto = document.getElementById('concepto').value;
        const estado = document.getElementById('estado').value;

        if (!valor || valor <= 0) {
            e.preventDefault();
            Swal.fire({
                title: 'Error',
                text: 'El valor debe ser mayor a 0',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }

        if (concepto.length < 10) {
            e.preventDefault();
            Swal.fire({
                title: 'Error',
                text: 'El concepto debe tener al menos 10 caracteres',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }

        if (estado === 'pagado' && !fechaPagoInput.value) {
            e.preventDefault();
            Swal.fire({
                title: 'Error',
                text: 'Debe especificar la fecha de pago para contratos pagados',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }

        // Show loading
        Swal.fire({
            title: 'Actualizando...',
            text: 'Por favor espere mientras se actualiza el contrato',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    });

    // Valor formatting
    const valorInput = document.getElementById('valor');
    valorInput.addEventListener('input', function() {
        let value = this.value.replace(/[^\d.]/g, '');
        this.value = value;
    });
});
</script>

@if(session('error'))
<script>
    Swal.fire({
        title: 'Error',
        text: "{{ session('error') }}",
        icon: 'error',
        confirmButtonText: 'Ok'
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        title: 'Errores de validación',
        html: '@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach',
        icon: 'error',
        confirmButtonText: 'Ok'
    });
</script>
@endif
@endsection
