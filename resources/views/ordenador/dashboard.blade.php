@extends('layouts.dashboard')

@section('title', 'Dashboard Ordenador')

@section('breadcrumb')
    @include('components.navigation.breadcrumb', [
        'items' => [
            ['label' => 'Dashboard Ordenador']
        ]
    ])
@endsection

@section('dashboard-header')
    <div class="glass-card p-6 slide-up">
        <div class="flex items-center space-x-4">
            <div class="gradient-secondary w-16 h-16 rounded-2xl flex items-center justify-center">
                <i class="fas fa-stamp text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Ordenador</h1>
                <p class="text-gray-600">Autorización y control de pagos</p>
            </div>
        </div>
    </div>
@endsection

@section('dashboard-content')
    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pendientes de autorización -->
        <div class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Por Autorizar</p>
                    <p class="text-3xl font-bold text-gray-800" data-counter="{{ $porAutorizar }}">{{ $porAutorizar }}</p>
                    <p class="text-sm text-orange-600 flex items-center mt-1">
                        <i class="fas fa-stamp mr-1"></i>
                        Pendientes
                    </p>
                </div>
                <div class="bg-gradient-to-br from-orange-400 to-orange-600 w-12 h-12 rounded-xl flex items-center justify-center">
                    <i class="fas fa-stamp text-white"></i>
                </div>
            </div>
        </div>
        
        <!-- Autorizadas hoy -->
        <div class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Autorizadas Hoy</p>
                    <p class="text-3xl font-bold text-gray-800" data-counter="{{ $autorizadasHoy }}">{{ $autorizadasHoy }}</p>
                    <p class="text-sm text-green-600 flex items-center mt-1">
                        <i class="fas fa-check-circle mr-1"></i>
                        ${{ number_format($valorAutorizadoHoy, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-gradient-to-br from-green-400 to-green-600 w-12 h-12 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
            </div>
        </div>
        
        <!-- Total autorizado -->
        <div class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Autorizado</p>
                    <p class="text-2xl font-bold text-gray-800">${{ number_format($valorTotalAutorizado, 0, ',', '.') }}</p>
                    <p class="text-sm text-blue-600 flex items-center mt-1">
                        <i class="fas fa-coins mr-1"></i>
                        {{ $eficienciaAutorizaciones }}% eficiencia
                    </p>
                </div>
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 w-12 h-12 rounded-xl flex items-center justify-center">
                    <i class="fas fa-coins text-white"></i>
                </div>
            </div>
        </div>
        
        <!-- Eficiencia -->
        <div class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Eficiencia</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $eficienciaAutorizaciones }}%</p>
                    <p class="text-sm text-purple-600 flex items-center mt-1">
                        <i class="fas fa-chart-line mr-1"></i>
                        Promedio: {{ $promedioDiario }}/día
                    </p>
                </div>
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 w-12 h-12 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('ordenador.autorizaciones.index') }}" class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-orange-500 to-red-600 w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-stamp text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors">Autorizaciones</h3>
                    <p class="text-sm text-gray-600">Revisar y autorizar</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('ordenador.ordenes.index') }}" class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-contract text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Órdenes</h3>
                    <p class="text-sm text-gray-600">Órdenes autorizadas</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('ordenador.perfil') }}" class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-green-500 to-teal-600 w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-tie text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Mi Perfil</h3>
                    <p class="text-sm text-gray-600">Información personal</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('dashboard') }}" class="glass-card p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-gray-500 to-gray-700 w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-home text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-gray-600 transition-colors">Dashboard General</h3>
                    <p class="text-sm text-gray-600">Ir al dashboard principal</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Gráfico y notificaciones -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Gráfico de evolución -->
        <div class="glass-card p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-chart-area text-blue-500 mr-3"></i>
                Evolución de Autorizaciones
            </h3>
            <div class="h-64">
                <canvas id="autorizacionesChart"></canvas>
            </div>
            
            <!-- Datos del gráfico para JavaScript -->
            <script>
                window.autorizacionesData = @json($evolucionAutorizaciones);
            </script>
        </div>

        <!-- Panel de notificaciones -->
        <div class="glass-card p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-bell text-yellow-500 mr-3"></i>
                Notificaciones
            </h3>
            
            @if(count($notificaciones) > 0)
                <div class="space-y-4">
                    @foreach($notificaciones as $notificacion)
                        <div class="p-4 rounded-xl border-l-4 transition-all hover:shadow-md
                            @if($notificacion['type'] === 'error') bg-red-50 border-red-400
                            @elseif($notificacion['type'] === 'warning') bg-yellow-50 border-yellow-400
                            @elseif($notificacion['type'] === 'info') bg-blue-50 border-blue-400
                            @elseif($notificacion['type'] === 'success') bg-green-50 border-green-400
                            @else bg-gray-50 border-gray-400 @endif">
                            <div class="flex items-start space-x-3">
                                <i class="{{ $notificacion['icon'] }} 
                                    @if($notificacion['type'] === 'error') text-red-500
                                    @elseif($notificacion['type'] === 'warning') text-yellow-500
                                    @elseif($notificacion['type'] === 'info') text-blue-500
                                    @elseif($notificacion['type'] === 'success') text-green-500
                                    @else text-gray-500 @endif"></i>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 text-sm">{{ $notificacion['title'] }}</h4>
                                    <p class="text-gray-600 text-sm mt-1">{{ $notificacion['message'] }}</p>
                                    @if(isset($notificacion['action']))
                                        <a href="{{ $notificacion['action'] }}" 
                                           class="inline-block mt-2 text-sm font-medium hover:underline
                                           @if($notificacion['type'] === 'error') text-red-600
                                           @elseif($notificacion['type'] === 'warning') text-yellow-600
                                           @elseif($notificacion['type'] === 'info') text-blue-600
                                           @elseif($notificacion['type'] === 'success') text-green-600
                                           @else text-gray-600 @endif">
                                            {{ $notificacion['action_text'] ?? 'Ver más' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell-slash text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500">No hay notificaciones por el momento</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Secciones de información -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Últimas pendientes de autorización -->
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-stamp text-orange-500 mr-3"></i>
                    Últimas por Autorizar
                </h3>
                <a href="{{ route('ordenador.autorizaciones.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($ultimasParaAutorizar->count() > 0)
                <div class="space-y-4">
                    @foreach($ultimasParaAutorizar->take(5) as $cuenta)
                        <div class="flex items-center space-x-4 p-3 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors">
                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">
                                    {{ strtoupper(substr($cuenta->user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 text-sm">{{ $cuenta->user->name }}</h4>
                                <p class="text-gray-600 text-xs">{{ Str::limit($cuenta->proyecto_servicio, 40) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-orange-600 text-sm">${{ number_format($cuenta->valor, 0, ',', '.') }}</p>
                                <p class="text-gray-500 text-xs">{{ $cuenta->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-stamp text-orange-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500">No hay cuentas pendientes de autorización</p>
                </div>
            @endif
        </div>

        <!-- Últimas autorizadas -->
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    Últimas Autorizadas
                </h3>
                <a href="{{ route('ordenador.ordenes.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($ultimasAutorizadas->count() > 0)
                <div class="space-y-4">
                    @foreach($ultimasAutorizadas->take(5) as $cuenta)
                        <div class="flex items-center space-x-4 p-3 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">
                                    {{ strtoupper(substr($cuenta->user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 text-sm">{{ $cuenta->user->name }}</h4>
                                <p class="text-gray-600 text-xs">{{ Str::limit($cuenta->proyecto_servicio, 40) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600 text-sm">${{ number_format($cuenta->valor, 0, ',', '.') }}</p>
                                <p class="text-gray-500 text-xs">{{ $cuenta->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500">No hay autorizaciones recientes</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de evolución de autorizaciones
    if (window.autorizacionesData) {
        const ctx = document.getElementById('autorizacionesChart').getContext('2d');
        const labels = window.autorizacionesData.map(item => item.day);
        const data = window.autorizacionesData.map(item => item.count);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Autorizaciones por día',
                    data: data,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Animación de contadores
    const counters = document.querySelectorAll('[data-counter]');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-counter'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current).toLocaleString();
        }, 16);
    });
});
</script>
@endsection
