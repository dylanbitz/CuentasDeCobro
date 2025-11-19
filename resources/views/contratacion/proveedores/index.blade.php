@extends('layouts.app')

@section('title', 'Directorio de Proveedores - Contratación')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-indigo-50 relative overflow-hidden">
    <!-- Background Animation -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('contratacion.dashboard') }}" class="text-gray-700 hover:text-purple-600 inline-flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Proveedores</span>
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
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-4 rounded-2xl shadow-lg mr-4">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                                    Directorio de Proveedores
                                </h1>
                                <p class="text-gray-600 text-lg mt-1">Gestiona y consulta información de proveedores y contratistas</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-6 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-database text-purple-500 mr-2"></i>
                                {{ $stats['total_proveedores'] ?? 0 }} proveedores registrados
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-chart-line text-purple-500 mr-2"></i>
                                {{ $stats['proveedores_activos'] ?? 0 }} activos este mes
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <button onclick="exportProveedores()" 
                                class="bg-white/70 hover:bg-white text-purple-700 border-2 border-purple-200 hover:border-purple-300 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <i class="fas fa-download mr-2"></i>
                            Exportar
                        </button>
                        <a href="{{ route('contratacion.dashboard') }}" 
                           class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>        <!-- Estadísticas y Filtros -->
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 mb-8">
            <!-- Stats Cards -->
            <div class="xl:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Proveedores -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center text-xs text-purple-600 font-semibold">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +5%
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Total Proveedores</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_proveedores'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-database mr-1"></i>
                            Registrados en el sistema
                        </p>
                    </div>
                </div>

                <!-- Proveedores Activos -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user-check text-white text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center text-xs text-green-600 font-semibold">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +12%
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Proveedores Activos</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['proveedores_activos'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-calendar mr-1"></i>
                            Con contratos recientes
                        </p>
                    </div>
                </div>

                <!-- Valor Total -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center text-xs text-blue-600 font-semibold">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +8%
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Valor Total</p>
                        <p class="text-3xl font-bold text-gray-800">${{ number_format($stats['valor_total'] ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-chart-line mr-1"></i>
                            En contratos activos
                        </p>
                    </div>
                </div>
            </div>

            <!-- Panel de Filtros -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-filter text-purple-500 mr-2"></i>
                    Filtros Rápidos
                </h3>
                <div class="space-y-3">
                    <button onclick="filterProveedores('todos')" class="filter-btn active w-full text-left px-4 py-2 rounded-lg bg-purple-100 text-purple-700 hover:bg-purple-200 transition-colors duration-200">
                        <i class="fas fa-users mr-2"></i>
                        Todos ({{ $stats['total_proveedores'] ?? 0 }})
                    </button>
                    <button onclick="filterProveedores('activos')" class="filter-btn w-full text-left px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-user-check mr-2"></i>
                        Activos ({{ $stats['proveedores_activos'] ?? 0 }})
                    </button>
                    <button onclick="filterProveedores('nuevos')" class="filter-btn w-full text-left px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-user-plus mr-2"></i>
                        Nuevos ({{ $stats['proveedores_nuevos'] ?? 0 }})
                    </button>
                    <button onclick="filterProveedores('inactivos')" class="filter-btn w-full text-left px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-user-times mr-2"></i>
                        Inactivos ({{ $stats['proveedores_inactivos'] ?? 0 }})
                    </button>
                </div>
            </div>
        </div>

        <!-- Barra de Búsqueda -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 mb-8 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center space-y-4 lg:space-y-0 lg:space-x-6">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="🔍 Buscar proveedores por nombre, email o cédula..." 
                               class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 text-lg"
                               onkeyup="searchProveedores()">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center">
                            <i class="fas fa-search text-gray-400 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <select id="sortBy" onchange="sortProveedores()" 
                            class="px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300">
                        <option value="name">📝 Ordenar por Nombre</option>
                        <option value="created_at">📅 Ordenar por Fecha</option>
                        <option value="contracts_count">📊 Ordenar por Contratos</option>
                        <option value="total_value">💰 Ordenar por Valor</option>
                    </select>
                    <button onclick="toggleView()" id="viewToggle" 
                            class="bg-purple-100 hover:bg-purple-200 text-purple-700 px-6 py-4 rounded-xl transition-all duration-300 flex items-center">
                        <i class="fas fa-th-large mr-2"></i>
                        Vista Tarjetas
                    </button>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>        <!-- Lista de Proveedores -->
        <div id="proveedoresContainer" class="transition-all duration-500">
            <!-- Vista de Tarjetas -->
            <div id="cardView" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($proveedores as $proveedor)
                <div class="proveedor-card bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group" 
                     data-name="{{ strtolower($proveedor->name) }}" 
                     data-email="{{ strtolower($proveedor->email) }}" 
                     data-contracts="{{ $proveedor->cuenta_cobros_count ?? 0 }}"
                     data-value="{{ $proveedor->cuenta_cobros_sum_valor ?? 0 }}"
                     data-status="{{ ($proveedor->cuenta_cobros_count ?? 0) > 0 ? 'activo' : 'inactivo' }}"
                     data-created="{{ $proveedor->created_at->format('Y-m-d') }}">
                    
                    <!-- Header de la Tarjeta -->
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-white/20 p-3 rounded-xl">
                                    <i class="fas fa-user text-white text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-white font-bold text-lg">{{ Str::limit($proveedor->name, 20) }}</h3>
                                    <p class="text-purple-100 text-sm">ID: {{ $proveedor->id }}</p>
                                </div>
                            </div>
                            @if(($proveedor->cuenta_cobros_count ?? 0) > 0)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                ✓ Activo
                            </span>
                            @else
                            <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                ⏸ Inactivo
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Contenido de la Tarjeta -->
                    <div class="p-6">
                        <!-- Información de Contacto -->
                        <div class="mb-6">
                            <div class="flex items-center text-gray-600 mb-2">
                                <i class="fas fa-envelope text-purple-500 mr-3"></i>
                                <span class="text-sm">{{ Str::limit($proveedor->email, 25) }}</span>
                            </div>
                            @if($proveedor->telefono)
                            <div class="flex items-center text-gray-600 mb-2">
                                <i class="fas fa-phone text-purple-500 mr-3"></i>
                                <span class="text-sm">{{ $proveedor->telefono }}</span>
                            </div>
                            @endif
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar text-purple-500 mr-3"></i>
                                <span class="text-sm">Registrado: {{ $proveedor->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $proveedor->cuenta_cobros_count ?? 0 }}</div>
                                <div class="text-xs text-blue-600 font-medium">Contratos</div>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4 text-center">
                                <div class="text-lg font-bold text-green-600">
                                    ${{ number_format(($proveedor->cuenta_cobros_sum_valor ?? 0) / 1000, 0) }}K
                                </div>
                                <div class="text-xs text-green-600 font-medium">Valor Total</div>
                            </div>
                        </div>

                        <!-- Indicador de Actividad -->
                        <div class="mb-6">                            @php
                                $ultimoContrato = $proveedor->cuenta_cobros()->latest()->first();
                                $diasSinActividad = $ultimoContrato ? intval($ultimoContrato->created_at->diffInDays(now())) : null;
                            @endphp
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Última actividad:</span>
                                @if($ultimoContrato)
                                    <span class="text-purple-600 font-medium">
                                        @if($diasSinActividad == 0)
                                            Hoy
                                        @elseif($diasSinActividad == 1)
                                            Ayer
                                        @else
                                            Hace {{ $diasSinActividad }} días
                                        @endif
                                    </span>
                                @else
                                    <span class="text-gray-400">Sin actividad</span>
                                @endif
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                @php
                                    $porcentajeActividad = $ultimoContrato && $diasSinActividad < 30 ? 100 - ($diasSinActividad * 3.33) : 0;
                                    $colorActividad = $porcentajeActividad > 70 ? 'green' : ($porcentajeActividad > 30 ? 'yellow' : 'red');
                                @endphp
                                <div class="bg-{{ $colorActividad }}-500 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ max($porcentajeActividad, 5) }}%"></div>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="flex space-x-3">
                            <a href="{{ route('contratacion.proveedores.show', $proveedor->id) }}" 
                               class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 py-3 rounded-xl font-semibold transition-all duration-300 transform group-hover:scale-105 text-center">
                                <i class="fas fa-eye mr-2"></i>
                                Ver Detalle
                            </a>
                            <button onclick="quickActions({{ $proveedor->id }})" 
                                    class="bg-white/70 hover:bg-white text-purple-700 border-2 border-purple-200 hover:border-purple-300 px-4 py-3 rounded-xl transition-all duration-300">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <i class="fas fa-users text-gray-400 text-6xl mb-6"></i>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">No hay proveedores registrados</h3>
                            <p class="text-gray-600 mb-8">Aún no se han registrado proveedores en el sistema. Los proveedores aparecerán aquí cuando creen cuentas de cobro.</p>
                            <a href="{{ route('contratacion.contratos.create') }}" 
                               class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>
                                Crear Primer Contrato
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Vista de Lista -->
            <div id="listView" class="hidden bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-list mr-3"></i>
                        Lista de Proveedores
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contratos</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/50 divide-y divide-gray-200">
                            @foreach($proveedores as $proveedor)
                            <tr class="proveedor-row hover:bg-white/70 transition-colors duration-200" 
                                data-name="{{ strtolower($proveedor->name) }}" 
                                data-email="{{ strtolower($proveedor->email) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $proveedor->name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $proveedor->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ $proveedor->email }}</div>
                                    @if($proveedor->telefono)
                                    <div class="text-sm text-gray-500">{{ $proveedor->telefono }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-blue-600">{{ $proveedor->cuenta_cobros_count ?? 0 }}</div>
                                    <div class="text-xs text-gray-500">contratos activos</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-green-600">
                                        ${{ number_format($proveedor->cuenta_cobros_sum_valor ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500">valor total</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(($proveedor->cuenta_cobros_count ?? 0) > 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        ✓ Activo
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                        ⏸ Inactivo
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('contratacion.proveedores.show', $proveedor->id) }}" 
                                       class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-eye mr-1"></i>
                                        Ver Detalle
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Paginación -->
        @if($proveedores->hasPages())
        <div class="mt-8">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando {{ $proveedores->firstItem() }} a {{ $proveedores->lastItem() }} de {{ $proveedores->total() }} proveedores
                    </div>
                    <div>
                        {{ $proveedores->links() }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Scripts JavaScript -->
<script>
let currentView = 'cards';
let originalData = [];

// Función para alternar entre vista de tarjetas y lista
function toggleView() {
    const cardView = document.getElementById('cardView');
    const listView = document.getElementById('listView');
    const toggleBtn = document.getElementById('viewToggle');
    
    if (currentView === 'cards') {
        cardView.classList.add('hidden');
        listView.classList.remove('hidden');
        toggleBtn.innerHTML = '<i class="fas fa-th mr-2"></i>Vista Tarjetas';
        currentView = 'list';
    } else {
        cardView.classList.remove('hidden'); 
        listView.classList.add('hidden');
        toggleBtn.innerHTML = '<i class="fas fa-list mr-2"></i>Vista Lista';
        currentView = 'cards';
    }
}

// Función de búsqueda
function searchProveedores() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.proveedor-card');
    const rows = document.querySelectorAll('.proveedor-row');
    
    cards.forEach(card => {
        const name = card.dataset.name;
        const email = card.dataset.email;
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            card.style.display = 'block';
            card.style.animation = 'fadeIn 0.3s ease-in';
        } else {
            card.style.display = 'none';
        }
    });
    
    rows.forEach(row => {
        const name = row.dataset.name;
        const email = row.dataset.email;
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
}

// Función de filtrado
function filterProveedores(filter) {
    const cards = document.querySelectorAll('.proveedor-card');
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    // Actualizar botones activos
    filterBtns.forEach(btn => {
        btn.classList.remove('active', 'bg-purple-100', 'text-purple-700');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });
    
    event.target.classList.add('active', 'bg-purple-100', 'text-purple-700');
    event.target.classList.remove('bg-gray-100', 'text-gray-700');
    
    cards.forEach(card => {
        let shouldShow = false;
        
        switch(filter) {
            case 'todos':
                shouldShow = true;
                break;
            case 'activos':
                shouldShow = card.dataset.status === 'activo';
                break;
            case 'nuevos':
                const createdDate = new Date(card.dataset.created);
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
                shouldShow = createdDate > thirtyDaysAgo;
                break;
            case 'inactivos':
                shouldShow = card.dataset.status === 'inactivo';
                break;
        }
        
        if (shouldShow) {
            card.style.display = 'block';
            card.style.animation = 'slideInUp 0.4s ease-out';
        } else {
            card.style.display = 'none';
        }
    });
}

// Función de ordenamiento
function sortProveedores() {
    const sortBy = document.getElementById('sortBy').value;
    const container = document.getElementById('cardView');
    const cards = Array.from(document.querySelectorAll('.proveedor-card'));
    
    cards.sort((a, b) => {
        switch(sortBy) {
            case 'name':
                return a.dataset.name.localeCompare(b.dataset.name);
            case 'created_at':
                return new Date(b.dataset.created) - new Date(a.dataset.created);
            case 'contracts_count':
                return parseInt(b.dataset.contracts) - parseInt(a.dataset.contracts);
            case 'total_value':
                return parseFloat(b.dataset.value) - parseFloat(a.dataset.value);
            default:
                return 0;
        }
    });
    
    // Reorganizar las tarjetas
    cards.forEach(card => container.appendChild(card));
    
    // Animación
    cards.forEach((card, index) => {
        card.style.animation = `slideInUp 0.3s ease-out ${index * 0.1}s both`;
    });
}

// Función para acciones rápidas
function quickActions(proveedorId) {
    Swal.fire({
        title: 'Acciones Rápidas',
        html: `
            <div class="space-y-3">
                <button onclick="viewDetails(${proveedorId})" class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600">
                    <i class="fas fa-eye mr-2"></i>Ver Detalles
                </button>
                <button onclick="createContract(${proveedorId})" class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600">
                    <i class="fas fa-plus mr-2"></i>Crear Contrato
                </button>
                <button onclick="exportData(${proveedorId})" class="w-full bg-purple-500 text-white p-3 rounded-lg hover:bg-purple-600">
                    <i class="fas fa-download mr-2"></i>Exportar Datos
                </button>
            </div>
        `,
        showConfirmButton: false,
        showCloseButton: true,
        width: 400
    });
}

function viewDetails(id) {
    window.location.href = `/contratacion/proveedores/${id}`;
}

function createContract(id) {
    window.location.href = `/contratacion/contratos/crear?proveedor=${id}`;
}

function exportData(id) {
    Swal.fire({
        icon: 'success',
        title: 'Exportando datos...',
        text: 'La descarga comenzará en breve',
        timer: 2000,
        showConfirmButton: false
    });
}

function exportProveedores() {
    Swal.fire({
        title: 'Exportar Proveedores',
        text: '¿En qué formato deseas exportar los datos?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-file-excel mr-2"></i>Excel',
        cancelButtonText: '<i class="fas fa-file-pdf mr-2"></i>PDF',
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#EF4444'
    }).then((result) => {
        if (result.isConfirmed) {
            // Exportar a Excel
            exportToExcel();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Exportar a PDF
            exportToPDF();
        }
    });
}

function exportToExcel() {
    Swal.fire({
        icon: 'success',
        title: 'Exportando a Excel...',
        timer: 2000,
        showConfirmButton: false
    });
}

function exportToPDF() {
    Swal.fire({
        icon: 'success',
        title: 'Exportando a PDF...',
        timer: 2000,
        showConfirmButton: false
    });
}

// Animaciones CSS adicionales
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
    
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
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
