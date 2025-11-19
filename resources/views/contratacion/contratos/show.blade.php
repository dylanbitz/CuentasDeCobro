@extends('layouts.app')

@section('title', 'Detalle del Contrato - Contratación')

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
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Contrato #{{ $contrato->id }}</span>
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
                                <i class="fas fa-file-contract text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    Contrato #{{ str_pad($contrato->id, 6, '0', STR_PAD_LEFT) }}
                                </h1>
                                <p class="text-gray-600 text-lg mt-1">{{ $contrato->concepto ?? 'Sin concepto definido' }}</p>
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
                                    'completado' => ['bg-purple-100 text-purple-800', 'fas fa-flag-checkered', 'Completado'],
                                    'pagado' => ['bg-gray-100 text-gray-800', 'fas fa-money-check-alt', 'Pagado']
                                ];
                                $estado = $contrato->estado ?? 'pendiente';
                                $config = $estadoConfig[$estado] ?? $estadoConfig['pendiente'];
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $config[0] }}">
                                <i class="{{ $config[1] }} mr-2"></i>
                                {{ $config[2] }}
                            </span>
                            <span class="text-gray-500 text-sm">
                                <i class="fas fa-calendar mr-1"></i>
                                Creado: {{ $contrato->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('contratacion.contratos.index') }}" 
                           class="bg-white/70 hover:bg-white text-gray-700 border-2 border-gray-200 hover:border-gray-300 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Volver
                        </a>
                        
                        @if($contrato->estado !== 'pagado' && $contrato->estado !== 'completado')
                        <a href="{{ route('contratacion.contratos.edit', $contrato->id) }}" 
                           class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Contrato
                        </a>
                        @endif
                        
                        <button onclick="generatePDF()" 
                                class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Exportar PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información del Contrato -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-8 transform hover:scale-[1.02] transition-all duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-xl shadow-lg mr-4">
                            <i class="fas fa-file-contract text-white text-xl"></i>
                        </div>
                        Información del Contrato
                    </h2>
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-4 rounded-xl border border-emerald-200">
                                <label class="block text-emerald-600 text-sm font-semibold mb-2 flex items-center">
                                    <i class="fas fa-hashtag mr-2"></i>
                                    Número de Contrato
                                </label>
                                <p class="text-gray-800 font-bold text-lg">CON-{{ str_pad($contrato->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                                <label class="block text-blue-600 text-sm font-semibold mb-2 flex items-center">
                                    <i class="fas fa-user mr-2"></i>
                                    Proveedor
                                </label>
                                <p class="text-gray-800 font-semibold text-lg">{{ $contrato->user->name ?? 'N/A' }}</p>
                                <p class="text-blue-600 text-sm mt-1">{{ $contrato->user->email ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-200">
                                <label class="block text-purple-600 text-sm font-semibold mb-2 flex items-center">
                                    <i class="fas fa-tag mr-2"></i>
                                    Concepto
                                </label>
                                <p class="text-gray-800 font-medium">{{ $contrato->concepto }}</p>
                            </div>
                            
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200">
                                <label class="block text-green-600 text-sm font-semibold mb-2 flex items-center">
                                    <i class="fas fa-dollar-sign mr-2"></i>
                                    Valor Total
                                </label>
                                <p class="text-gray-800 font-bold text-2xl">${{ number_format($contrato->valor, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <div class="bg-gradient-to-r from-gray-50 to-slate-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-gray-600 text-sm font-semibold mb-2 flex items-center">
                                    <i class="fas fa-flag mr-2"></i>
                                    Estado Actual
                                </label>
                                @php
                                    $estadoConfig = [
                                        'pendiente' => ['bg-yellow-100 text-yellow-800', 'fas fa-clock', 'Pendiente'],
                                        'aprobado' => ['bg-green-100 text-green-800', 'fas fa-check-circle', 'Aprobado'],
                                        'rechazado' => ['bg-red-100 text-red-800', 'fas fa-times-circle', 'Rechazado'],
                                        'en_proceso' => ['bg-blue-100 text-blue-800', 'fas fa-cogs', 'En Proceso'],
                                        'completado' => ['bg-purple-100 text-purple-800', 'fas fa-flag-checkered', 'Completado'],
                                        'pagado' => ['bg-gray-100 text-gray-800', 'fas fa-money-check-alt', 'Pagado']
                                    ];
                                    $estado = $contrato->estado ?? 'pendiente';
                                    $config = $estadoConfig[$estado] ?? $estadoConfig['pendiente'];
                                @endphp
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $config[0] }}">
                                    <i class="{{ $config[1] }} mr-2"></i>
                                    {{ $config[2] }}
                                </span>
                            </div>
                            
                            <div class="bg-gradient-to-r from-orange-50 to-amber-50 p-4 rounded-xl border border-orange-200">
                                <label class="block text-orange-600 text-sm font-semibold mb-2 flex items-center">
                                    <i class="fas fa-calendar-plus mr-2"></i>
                                    Fecha de Creación
                                </label>
                                <p class="text-gray-800 font-medium">{{ $contrato->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-orange-600 text-sm mt-1">{{ $contrato->created_at->diffForHumans() }}</p>
                            </div>
                            
                            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 p-4 rounded-xl border border-teal-200">
                                <label class="block text-teal-600 text-sm font-semibold mb-2 flex items-center">
                                    <i class="fas fa-calendar-edit mr-2"></i>
                                    Última Actualización
                                </label>
                                <p class="text-gray-800 font-medium">{{ $contrato->updated_at->format('d/m/Y H:i') }}</p>
                                <p class="text-teal-600 text-sm mt-1">{{ $contrato->updated_at->diffForHumans() }}</p>
                            </div>
                            
                            @if($contrato->fecha_pago)
                            <div class="bg-gradient-to-r from-emerald-50 to-green-50 p-4 rounded-xl border border-emerald-200">
                                <label class="block text-emerald-600 text-sm font-semibold mb-2 flex items-center">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Fecha de Pago
                                </label>
                                <p class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($contrato->fecha_pago)->format('d/m/Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>                <!-- Detalles Adicionales -->
                @if($contrato->observaciones || $contrato->descripcion)
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-8 transform hover:scale-[1.02] transition-all duration-300">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-xl shadow-lg mr-4">
                            <i class="fas fa-clipboard-list text-white text-xl"></i>
                        </div>
                        Detalles Adicionales
                    </h3>
                    
                    @if($contrato->descripcion)
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-purple-600"></i>
                            Descripción del Contrato
                        </h4>
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-200">
                            <p class="text-gray-800 leading-relaxed">{{ $contrato->descripcion }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($contrato->observaciones)
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-sticky-note mr-2 text-amber-600"></i>
                            Observaciones
                        </h4>
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-200">
                            <p class="text-gray-800 leading-relaxed">{{ $contrato->observaciones }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif                <!-- Historial de Estados -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-8 transform hover:scale-[1.02] transition-all duration-300">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-xl shadow-lg mr-4">
                            <i class="fas fa-history text-white text-xl"></i>
                        </div>
                        Historial del Contrato
                    </h3>
                    
                    <div class="relative">
                        <!-- Línea de tiempo -->
                        <div class="absolute left-6 top-8 bottom-8 w-0.5 bg-gradient-to-b from-emerald-400 to-teal-400"></div>
                        
                        <div class="space-y-6">
                            <!-- Contrato creado -->
                            <div class="flex items-start space-x-6 relative">
                                <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full flex items-center justify-center shadow-lg z-10">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-4 rounded-xl border border-emerald-200 flex-1">
                                    <h4 class="text-emerald-700 font-semibold mb-1">Contrato creado</h4>
                                    <p class="text-gray-600 text-sm">{{ $contrato->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-emerald-600 text-xs mt-1">{{ $contrato->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                            @if($contrato->updated_at != $contrato->created_at)
                            <!-- Última actualización -->
                            <div class="flex items-start space-x-6 relative">
                                <div class="w-12 h-12 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full flex items-center justify-center shadow-lg z-10">
                                    <i class="fas fa-edit text-white"></i>
                                </div>
                                <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-4 rounded-xl border border-amber-200 flex-1">
                                    <h4 class="text-amber-700 font-semibold mb-1">Contrato actualizado</h4>
                                    <p class="text-gray-600 text-sm">{{ $contrato->updated_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-amber-600 text-xs mt-1">{{ $contrato->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($contrato->fecha_pago)
                            <!-- Contrato pagado -->
                            <div class="flex items-start space-x-6 relative">
                                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-lg z-10">
                                    <i class="fas fa-check-circle text-white"></i>
                                </div>
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200 flex-1">
                                    <h4 class="text-green-700 font-semibold mb-1">Pago procesado</h4>
                                    <p class="text-gray-600 text-sm">{{ \Carbon\Carbon::parse($contrato->fecha_pago)->format('d/m/Y') }}</p>
                                    <p class="text-green-600 text-xs mt-1">Contrato completado exitosamente</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Estado actual -->
                            <div class="flex items-start space-x-6 relative">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg z-10 animate-pulse">
                                    <i class="fas fa-flag text-white"></i>
                                </div>
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200 flex-1">
                                    <h4 class="text-blue-700 font-semibold mb-1">Estado actual: {{ ucfirst($contrato->estado) }}</h4>
                                    <p class="text-gray-600 text-sm">Última verificación: {{ now()->format('d/m/Y H:i') }}</p>
                                    <p class="text-blue-600 text-xs mt-1">Estado activo del contrato</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            <!-- Panel Lateral -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Archivos -->
                @if($contrato->archivo_cuenta_cobro)
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 transform hover:scale-[1.02] transition-all duration-300">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-r from-red-500 to-pink-600 p-2 rounded-lg shadow-lg mr-3">
                            <i class="fas fa-paperclip text-white"></i>
                        </div>
                        Archivos
                    </h3>
                    <div class="space-y-3">
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 p-4 rounded-xl border border-red-200 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-800 font-semibold">Cuenta de Cobro</p>
                                        <p class="text-red-600 text-sm">{{ basename($contrato->archivo_cuenta_cobro) }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ Storage::url($contrato->archivo_cuenta_cobro) }}" 
                                       target="_blank" 
                                       class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition-colors"
                                       title="Ver archivo">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ Storage::url($contrato->archivo_cuenta_cobro) }}" 
                                       download
                                       class="bg-green-100 hover:bg-green-200 text-green-600 p-2 rounded-lg transition-colors"
                                       title="Descargar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif                <!-- Información del Proveedor -->
                @if($contrato->user)
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 transform hover:scale-[1.02] transition-all duration-300">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-2 rounded-lg shadow-lg mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        Información del Proveedor
                    </h3>
                    
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800">{{ $contrato->user->name }}</h4>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-3 rounded-lg border border-blue-200">
                            <label class="block text-blue-600 text-xs font-semibold mb-1 uppercase tracking-wide">Email</label>
                            <p class="text-gray-800 font-medium">{{ $contrato->user->email }}</p>
                        </div>
                        
                        @if($contrato->user->telefono)
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-3 rounded-lg border border-green-200">
                            <label class="block text-green-600 text-xs font-semibold mb-1 uppercase tracking-wide">Teléfono</label>
                            <p class="text-gray-800 font-medium">{{ $contrato->user->telefono }}</p>
                        </div>
                        @endif
                        
                        <div class="bg-gradient-to-r from-gray-50 to-slate-50 p-3 rounded-lg border border-gray-200">
                            <label class="block text-gray-600 text-xs font-semibold mb-1 uppercase tracking-wide">Registro</label>
                            <p class="text-gray-800 font-medium">{{ $contrato->user->created_at->format('d/m/Y') }}</p>
                        </div>
                        
                        <div class="pt-3 border-t border-gray-200">
                            <a href="{{ route('contratacion.proveedores.show', $contrato->user->id) }}" 
                               class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center block">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Ver perfil completo
                            </a>
                        </div>
                    </div>
                </div>
                @endif                <!-- Acciones Rápidas -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 transform hover:scale-[1.02] transition-all duration-300">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-2 rounded-lg shadow-lg mr-3">
                            <i class="fas fa-cogs text-white"></i>
                        </div>
                        Acciones Rápidas
                    </h3>
                    
                    <div class="space-y-3">
                        @if($contrato->estado !== 'pagado' && $contrato->estado !== 'completado')
                        <a href="{{ route('contratacion.contratos.edit', $contrato->id) }}" 
                           class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center block">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Contrato
                        </a>
                        @endif
                        
                        <button onclick="generatePDF()" 
                                class="w-full bg-gradient-to-r from-red-600 to-pink-700 hover:from-red-700 hover:to-pink-800 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Exportar PDF
                        </button>
                        
                        <button onclick="printContract()" 
                                class="w-full bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-print mr-2"></i>
                            Imprimir Contrato
                        </button>
                        
                        <button onclick="shareContract()" 
                                class="w-full bg-gradient-to-r from-teal-600 to-cyan-700 hover:from-teal-700 hover:to-cyan-800 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-share-alt mr-2"></i>
                            Compartir
                        </button>
                        
                        @if($contrato->estado !== 'pagado' && $contrato->estado !== 'completado')
                        <div class="pt-3 border-t border-gray-200">
                            <button onclick="deleteContract({{ $contrato->id }})" 
                                    class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-trash mr-2"></i>
                                Eliminar Contrato
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Estadísticas del Contrato -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 transform hover:scale-[1.02] transition-all duration-300">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-2 rounded-lg shadow-lg mr-3">
                            <i class="fas fa-chart-pie text-white"></i>
                        </div>
                        Estadísticas
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-3 rounded-lg border border-emerald-200">
                            <div class="flex justify-between items-center">
                                <span class="text-emerald-700 font-medium">Días transcurridos</span>
                                <span class="text-emerald-800 font-bold">{{ $contrato->created_at->diffInDays(now()) }}</span>
                            </div>
                        </div>
                        
                        @if($contrato->fecha_inicio && $contrato->fecha_fin)
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-3 rounded-lg border border-blue-200">
                            <div class="flex justify-between items-center">
                                <span class="text-blue-700 font-medium">Duración total</span>
                                <span class="text-blue-800 font-bold">{{ \Carbon\Carbon::parse($contrato->fecha_inicio)->diffInDays(\Carbon\Carbon::parse($contrato->fecha_fin)) }} días</span>
                            </div>
                        </div>
                        @endif
                        
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-3 rounded-lg border border-purple-200">
                            <div class="flex justify-between items-center">
                                <span class="text-purple-700 font-medium">Valor por día</span>
                                <span class="text-purple-800 font-bold">
                                    ${{ number_format($contrato->valor / max(1, $contrato->created_at->diffInDays(now()) ?: 1), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
function printContract() {
    window.print();
}

function deleteContract(contratoId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/contratacion/contratos/${contratoId}`;
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = '{{ csrf_token() }}';
            
            form.appendChild(methodField);
            form.appendChild(tokenField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeAnimations();
    setupTooltips();
});

// Configurar animaciones
function initializeAnimations() {
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.transform');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Configurar tooltips
function setupTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(event) {
    const element = event.target;
    const title = element.getAttribute('title');
    
    if (!title) return;
    
    const tooltip = document.createElement('div');
    tooltip.className = 'fixed bg-gray-800 text-white px-2 py-1 rounded text-sm z-50 pointer-events-none';
    tooltip.textContent = title;
    tooltip.id = 'custom-tooltip';
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + 'px';
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
    
    element.removeAttribute('title');
    element.setAttribute('data-original-title', title);
}

function hideTooltip(event) {
    const tooltip = document.getElementById('custom-tooltip');
    if (tooltip) {
        tooltip.remove();
    }
    
    const element = event.target;
    const originalTitle = element.getAttribute('data-original-title');
    if (originalTitle) {
        element.setAttribute('title', originalTitle);
        element.removeAttribute('data-original-title');
    }
}

// Generar PDF
function generatePDF() {
    Swal.fire({
        title: 'Generando PDF...',
        text: 'Por favor espera mientras se genera el documento',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Simular generación de PDF (aquí iría la lógica real)
    setTimeout(() => {
        Swal.fire({
            title: '¡PDF Generado!',
            text: 'El documento se ha generado exitosamente',
            icon: 'success',
            confirmButtonColor: '#059669',
            confirmButtonText: 'Descargar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría la descarga real del PDF
                window.print();
            }
        });
    }, 2000);
}

// Compartir contrato
function shareContract() {
    const contractUrl = window.location.href;
    const contractTitle = 'Contrato #{{ str_pad($contrato->id, 6, '0', STR_PAD_LEFT) }}';
    
    if (navigator.share) {
        navigator.share({
            title: contractTitle,
            text: 'Consulta este contrato en el sistema de contratación',
            url: contractUrl
        }).catch(console.error);
    } else {
        // Fallback: copiar al portapapeles
        navigator.clipboard.writeText(contractUrl).then(() => {
            Swal.fire({
                title: 'Enlace copiado',
                text: 'El enlace del contrato se ha copiado al portapapeles',
                icon: 'success',
                confirmButtonColor: '#059669',
                timer: 2000,
                showConfirmButton: false
            });
        }).catch(() => {
            // Fallback manual
            Swal.fire({
                title: 'Compartir contrato',
                text: 'Copia este enlace para compartir:',
                input: 'text',
                inputValue: contractUrl,
                inputAttributes: {
                    readonly: true
                },
                confirmButtonColor: '#059669',
                confirmButtonText: 'Cerrar'
            });
        });
    }
}
</script>

<!-- Estilos adicionales para animaciones -->
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

/* Animaciones de hover mejoradas */
.transform:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
}

/* Efectos de gradiente animado */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradientShift 6s ease infinite;
}

/* Efecto de pulso para elementos activos */
@keyframes pulse-soft {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.animate-pulse {
    animation: pulse-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Éxito',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#059669',
        timer: 4000,
        timerProgressBar: true
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Error',
        text: "{{ session('error') }}",
        icon: 'error',
        confirmButtonColor: '#059669'
    });
</script>
@endif
@endsection
