@extends('layouts.app')

@section('title', 'Gestión de Contratos - Contratación')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden">
    <!-- Background Animation -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-cyan-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10">        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('contratacion.dashboard') }}" class="text-gray-700 hover:text-emerald-600 inline-flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Gestión de Contratos</span>
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
                                    Gestión de Contratos
                                </h1>
                                <p class="text-gray-600 text-lg mt-1">Administra todos los contratos del sistema de manera eficiente</p>
                            </div>
                        </div>
                        
                        <!-- Estadísticas rápidas -->
                        <div class="flex items-center space-x-6 text-sm text-gray-600">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full mr-2"></div>
                                <span>{{ $stats['total_contratos'] ?? 0 }} contratos totales</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span>${{ number_format($stats['valor_total'] ?? 0, 0, ',', '.') }} en total</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <button onclick="toggleView()" 
                                class="bg-white/70 hover:bg-white text-gray-700 border-2 border-gray-200 hover:border-gray-300 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            <i class="fas fa-th-large mr-2" id="viewIcon"></i>
                            <span id="viewText">Vista de Tarjetas</span>
                        </button>
                        
                        <a href="{{ route('contratacion.contratos.create') }}" 
                           class="bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            <i class="fas fa-plus mr-2"></i>
                            Nuevo Contrato
                        </a>
                    </div>
                </div>
            </div>
        </div>        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Contratos</p>
                        <p class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                            {{ $stats['total_contratos'] ?? 0 }}
                        </p>
                        <p class="text-xs text-emerald-600 mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>
                            Activos en el sistema
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-4 rounded-2xl shadow-lg">
                        <i class="fas fa-file-contract text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Valor Total</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                            ${{ number_format($stats['valor_total'] ?? 0, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-green-600 mt-1">
                            <i class="fas fa-chart-line mr-1"></i>
                            Suma de todos los contratos
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4 rounded-2xl shadow-lg">
                        <i class="fas fa-dollar-sign text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Valor Promedio</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            ${{ number_format($stats['promedio_valor'] ?? 0, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-purple-600 mt-1">
                            <i class="fas fa-calculator mr-1"></i>
                            Por contrato
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-4 rounded-2xl shadow-lg">
                        <i class="fas fa-calculator text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Este Mes</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            {{ $contratos->where('created_at', '>=', now()->startOfMonth())->count() }}
                        </p>
                        <p class="text-xs text-blue-600 mt-1">
                            <i class="fas fa-calendar mr-1"></i>
                            Contratos nuevos
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4 rounded-2xl shadow-lg">
                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>        <!-- Filters and Search -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg mr-4">
                    <i class="fas fa-search text-white text-lg"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Filtros y Búsqueda Avanzada</h3>
            </div>
            
            <form method="GET" action="{{ route('contratacion.contratos.index') }}" class="space-y-6" id="searchForm">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">                    <!-- Búsqueda -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-search mr-2 text-blue-600"></i>
                            Búsqueda Global
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   id="searchInput"
                                   value="{{ request('search') }}" 
                                   placeholder="ID, concepto, proveedor, etc..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white/70 backdrop-blur-sm">
                            <div class="absolute left-3 top-3.5">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            @if(request('search'))
                            <button type="button" onclick="clearSearch()" class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                    </div>                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-flag mr-2 text-green-600"></i>
                            Estado
                        </label>
                        <select name="estado" 
                                class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white/70 backdrop-blur-sm">
                            <option value="">Todos los estados</option>
                            @if(isset($estados))
                                @foreach($estados as $key => $nombre)
                                <option value="{{ $key }}" {{ request('estado') == $key ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            @else
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            @endif
                        </select>
                    </div>

                    <!-- Proveedor -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-user mr-2 text-purple-600"></i>
                            Proveedor
                        </label>
                        <select name="proveedor_id" 
                                class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white/70 backdrop-blur-sm">
                            <option value="">Todos los proveedores</option>
                            @if(isset($proveedores))
                                @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ request('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->name }}
                                </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Fecha Desde -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-orange-600"></i>
                            Desde
                        </label>
                        <input type="date" 
                               name="fecha_desde" 
                               value="{{ request('fecha_desde') }}" 
                               class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white/70 backdrop-blur-sm">
                    </div>

                    <!-- Fecha Hasta -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-calendar-check mr-2 text-red-600"></i>
                            Hasta
                        </label>
                        <input type="date" 
                               name="fecha_hasta" 
                               value="{{ request('fecha_hasta') }}" 
                               class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white/70 backdrop-blur-sm">
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Mostrando {{ $contratos->firstItem() ?? 0 }} - {{ $contratos->lastItem() ?? 0 }} de {{ $contratos->total() }} contratos
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Buscar
                        </button>
                        <a href="{{ route('contratacion.contratos.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200">
                            <i class="fas fa-refresh mr-2"></i>
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Contracts List -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 class="text-xl font-semibold text-white">
                    <i class="fas fa-list mr-2"></i>
                    Lista de Contratos
                </h3>
            </div>

            @if($contratos->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto/Servicio</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contratista</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Emisión</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
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
                                <div class="text-sm text-gray-900 font-medium">{{ Str::limit($contrato->proyecto_servicio, 50) }}</div>
                                @if($contrato->descripcion)
                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($contrato->descripcion, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $contrato->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $contrato->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-green-600">
                                    ${{ number_format($contrato->valor, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $contrato->fecha_emision->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $contrato->fecha_emision->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($contrato->estado === 'pendiente') bg-orange-100 text-orange-800
                                    @elseif($contrato->estado === 'aprobado') bg-green-100 text-green-800
                                    @elseif($contrato->estado === 'revision') bg-blue-100 text-blue-800
                                    @elseif($contrato->estado === 'pagado') bg-purple-100 text-purple-800
                                    @elseif($contrato->estado === 'rechazado') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $contrato->estado_formateado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('contratacion.contratos.show', $contrato->id) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-xs font-semibold transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Ver
                                    </a>
                                    <a href="{{ route('contratacion.contratos.edit', $contrato->id) }}" 
                                       class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded-lg text-xs font-semibold transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('contratacion.contratos.destroy', $contrato->id) }}" 
                                          class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este contrato?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs font-semibold transition-colors duration-200">
                                            <i class="fas fa-trash mr-1"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4">
                {{ $contratos->withQueryString()->links() }}
            </div>
            @else
            <div class="p-12 text-center">
                <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-file-contract text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay contratos</h3>
                <p class="text-gray-500 mb-6">Comienza creando tu primer contrato en el sistema.</p>
                <a href="{{ route('contratacion.contratos.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Primer Contrato
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Scripts para funcionalidad avanzada -->
<script>
// Variables globales
let currentView = 'table';
let isSearching = false;

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeAnimations();
    setupRealTimeSearch();
    setupFormEnhancements();
});

// Configurar animaciones de entrada
function initializeAnimations() {
    // Animación escalonada para las tarjetas de estadísticas
    const statCards = document.querySelectorAll('.transform');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
        }, index * 150);
    });

    // Animación para las filas de la tabla
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.4s ease-out';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, (index * 50) + 500);
    });
}

// Búsqueda en tiempo real
function setupRealTimeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 300);
    });
}

function performSearch(query) {
    if (query.length < 2 && query.length > 0) return;
    
    isSearching = query.length > 0;
    
    // Aquí se implementaría la búsqueda AJAX real
    // Por ahora, mostrar indicador visual
    const searchInput = document.getElementById('searchInput');
    
    if (isSearching) {
        searchInput.classList.add('ring-2', 'ring-emerald-500');
        showSearchIndicator();
    } else {
        searchInput.classList.remove('ring-2', 'ring-emerald-500');
        hideSearchIndicator();
    }
}

function showSearchIndicator() {
    // Crear o mostrar indicador de búsqueda
    let indicator = document.getElementById('searchIndicator');
    if (!indicator) {
        indicator = document.createElement('div');
        indicator.id = 'searchIndicator';
        indicator.className = 'absolute right-10 top-3.5 text-emerald-500';
        indicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.querySelector('#searchInput').parentNode.appendChild(indicator);
    }
    indicator.style.display = 'block';
    
    // Ocultar después de un tiempo
    setTimeout(() => {
        if (indicator) {
            indicator.style.display = 'none';
        }
    }, 1000);
}

function hideSearchIndicator() {
    const indicator = document.getElementById('searchIndicator');
    if (indicator) {
        indicator.style.display = 'none';
    }
}

// Limpiar búsqueda
function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = '';
    searchInput.classList.remove('ring-2', 'ring-emerald-500');
    
    // Recargar página sin parámetros de búsqueda
    const url = new URL(window.location);
    url.searchParams.delete('search');
    window.location.href = url.toString();
}

// Alternar vista (preparado para implementación futura)
function toggleView() {
    const viewIcon = document.getElementById('viewIcon');
    const viewText = document.getElementById('viewText');
    
    if (currentView === 'table') {
        currentView = 'cards';
        viewIcon.className = 'fas fa-list mr-2';
        viewText.textContent = 'Vista de Lista';
        
        Swal.fire({
            title: 'Vista de Tarjetas',
            text: 'Esta funcionalidad estará disponible próximamente',
            icon: 'info',
            confirmButtonColor: '#059669',
            timer: 2000,
            showConfirmButton: false
        });
    } else {
        currentView = 'table';
        viewIcon.className = 'fas fa-th-large mr-2';
        viewText.textContent = 'Vista de Tarjetas';
    }
}

// Configurar mejoras del formulario
function setupFormEnhancements() {
    // Auto-submit en cambio de filtros
    const filterSelects = document.querySelectorAll('select[name="estado"], select[name="proveedor_id"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Mostrar indicador de carga
            showLoadingIndicator();
            
            // Enviar formulario automáticamente
            setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 500);
        });
    });

    // Mejorar campos de fecha
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            validateDateRange();
            
            // Auto-submit si ambas fechas están completas
            const fechaDesde = document.querySelector('input[name="fecha_desde"]').value;
            const fechaHasta = document.querySelector('input[name="fecha_hasta"]').value;
            
            if (fechaDesde && fechaHasta) {
                showLoadingIndicator();
                setTimeout(() => {
                    document.getElementById('searchForm').submit();
                }, 500);
            }
        });
    });
}

function validateDateRange() {
    const fechaDesde = document.querySelector('input[name="fecha_desde"]');
    const fechaHasta = document.querySelector('input[name="fecha_hasta"]');
    
    if (fechaDesde.value && fechaHasta.value) {
        const inicio = new Date(fechaDesde.value);
        const fin = new Date(fechaHasta.value);
        
        if (inicio > fin) {
            Swal.fire({
                icon: 'warning',
                title: 'Rango de fechas inválido',
                text: 'La fecha de inicio no puede ser posterior a la fecha final',
                confirmButtonColor: '#059669'
            });
            
            fechaHasta.value = fechaDesde.value;
        }
    }
}

function showLoadingIndicator() {
    Swal.fire({
        title: 'Aplicando filtros...',
        text: 'Por favor espera',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
}

// Exportar datos (funcionalidad futura)
function exportData(format) {
    Swal.fire({
        title: `Exportar como ${format.toUpperCase()}`,
        text: 'Esta funcionalidad estará disponible próximamente',
        icon: 'info',
        confirmButtonColor: '#059669'
    });
}

// Acciones en lote (funcionalidad futura)
function bulkActions() {
    Swal.fire({
        title: 'Acciones en lote',
        text: 'Selecciona múltiples contratos para realizar acciones en conjunto',
        icon: 'info',
        confirmButtonColor: '#059669'
    });
}

// Configurar tooltips mejorados
function setupAdvancedTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            showAdvancedTooltip(this);
        });
        
        element.addEventListener('mouseleave', function() {
            hideAdvancedTooltip();
        });
    });
}

function showAdvancedTooltip(element) {
    const tooltip = document.createElement('div');
    tooltip.className = 'fixed bg-gray-800 text-white px-3 py-2 rounded-lg text-sm z-50 pointer-events-none shadow-lg';
    tooltip.innerHTML = element.getAttribute('data-tooltip');
    tooltip.id = 'advanced-tooltip';
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
    
    // Animación de entrada
    tooltip.style.opacity = '0';
    tooltip.style.transform = 'translateY(10px)';
    
    setTimeout(() => {
        tooltip.style.transition = 'all 0.2s ease-out';
        tooltip.style.opacity = '1';
        tooltip.style.transform = 'translateY(0)';
    }, 10);
}

function hideAdvancedTooltip() {
    const tooltip = document.getElementById('advanced-tooltip');
    if (tooltip) {
        tooltip.style.opacity = '0';
        tooltip.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            tooltip.remove();
        }, 200);
    }
}
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

/* Efectos de gradiente animado */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradientShift 8s ease infinite;
}

/* Mejoras en la tabla */
tbody tr:hover {
    background-color: rgba(16, 185, 129, 0.05) !important;
    transform: translateX(5px);
    transition: all 0.3s ease;
}

/* Efectos de búsqueda */
#searchInput:focus {
    background-color: white;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Animaciones de los botones */
.transform:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>

<!-- SweetAlert para notificaciones -->
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session("success") }}',
        confirmButtonColor: '#059669',
        timer: 4000,
        timerProgressBar: true,
        showConfirmButton: false
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
        confirmButtonColor: '#059669'
    });
});
</script>
@endif
@endsection
