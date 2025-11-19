<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CuentaCobro;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrdenadorController extends Controller
{
    /**
     * Display ordenador dashboard with real data
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Verificar que el usuario sea ordenador
        if (!$user->hasRole('ordenador')) {
            abort(403, 'Acceso denegado. Solo el ordenador puede acceder a esta vista.');
        }

        // Obtener datos principales del ordenador
        $dashboardData = $this->getOrdenadorData($user);
        
        return view('ordenador.dashboard', $dashboardData);
    }

    /**
     * Get all ordenador-specific data
     */
    private function getOrdenadorData($user)
    {
        $now = Carbon::now();

        // Estadísticas principales para autorización
        $totalCuentas = CuentaCobro::count();
        $porAutorizar = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->count(); // Cuentas aprobadas por supervisor, pendientes de autorización
        $autorizadasHoy = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
            ->whereDate('updated_at', Carbon::today())
            ->count();
        $totalPendientes = CuentaCobro::whereIn('estado', [
            CuentaCobro::ESTADO_PENDIENTE, 
            CuentaCobro::ESTADO_REVISION
        ])->count();

        // Valores monetarios
        $valorPorAutorizar = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->sum('valor');
        $valorAutorizadoHoy = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
            ->whereDate('updated_at', Carbon::today())
            ->sum('valor');
        $valorTotalAutorizado = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->sum('valor');
        $valorPendienteRevision = CuentaCobro::whereIn('estado', [
            CuentaCobro::ESTADO_PENDIENTE, 
            CuentaCobro::ESTADO_REVISION
        ])->sum('valor');

        // Últimas cuentas para autorizar (límite 10)
        $ultimasParaAutorizar = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)
            ->with(['user'])
            ->latest('updated_at')
            ->limit(10)
            ->get();

        // Últimas autorizaciones realizadas (últimas 10)
        $ultimasAutorizadas = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
            ->with(['user'])
            ->latest('updated_at')
            ->limit(10)
            ->get();

        // Estadísticas del mes actual
        $estadisticasMes = [
            'autorizadas_mes' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                ->whereMonth('updated_at', $now->month)
                ->count(),
            'valor_autorizado_mes' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                ->whereMonth('updated_at', $now->month)
                ->sum('valor'),
            'por_autorizar_mes' => CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)
                ->whereMonth('created_at', $now->month)
                ->count(),
            'valor_por_autorizar_mes' => CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)
                ->whereMonth('created_at', $now->month)
                ->sum('valor')
        ];

        // Evolución de autorizaciones por día (últimos 30 días)
        $evolucionAutorizaciones = $this->getAutorizacionesPorDia();

        // Notificaciones para ordenador
        $notificaciones = $this->getOrdenadorNotifications();

        // Promedio diario de autorizaciones del mes
        $promedioDiario = $this->getPromedioDiarioMes();

        // Eficiencia de autorizaciones (% de cuentas aprobadas que ya fueron autorizadas)
        $totalAprobadas = CuentaCobro::whereIn('estado', [
            CuentaCobro::ESTADO_APROBADO, 
            CuentaCobro::ESTADO_PAGADO
        ])->count();
        $autorizadas = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->count();
        $eficienciaAutorizaciones = $totalAprobadas > 0 ? round(($autorizadas / $totalAprobadas) * 100, 1) : 0;

        return [
            'user' => $user,
            'userRole' => $user->role->name,
            
            // Estadísticas principales
            'totalCuentas' => $totalCuentas,
            'porAutorizar' => $porAutorizar,
            'autorizadasHoy' => $autorizadasHoy,
            'totalPendientes' => $totalPendientes,
            
            // Valores monetarios
            'valorPorAutorizar' => $valorPorAutorizar,
            'valorAutorizadoHoy' => $valorAutorizadoHoy,
            'valorTotalAutorizado' => $valorTotalAutorizado,
            'valorPendienteRevision' => $valorPendienteRevision,
            
            // Colecciones de datos
            'ultimasParaAutorizar' => $ultimasParaAutorizar,
            'ultimasAutorizadas' => $ultimasAutorizadas,
            'estadisticasMes' => $estadisticasMes,
            'evolucionAutorizaciones' => $evolucionAutorizaciones,
            'notificaciones' => $notificaciones,
            
            // Datos calculados
            'eficienciaAutorizaciones' => $eficienciaAutorizaciones,
            'promedioDiario' => $promedioDiario,
        ];
    }

    /**
     * Lista de autorizaciones pendientes
     */
    public function autorizaciones(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('ordenador')) {
            abort(403, 'Acceso denegado');
        }

        $query = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)
                            ->with(['user']);

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('proyecto_servicio', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('mes')) {
            $query->whereMonth('created_at', $request->mes);
        }

        if ($request->filled('valor_min')) {
            $query->where('valor', '>=', $request->valor_min);
        }

        if ($request->filled('valor_max')) {
            $query->where('valor', '<=', $request->valor_max);
        }

        // Ordenar por prioridad: más antiguas primero, luego por valor descendente
        $autorizaciones = $query->orderBy('updated_at', 'asc')
                               ->orderBy('valor', 'desc')
                               ->paginate(25);

        // Estadísticas para mostrar en la vista
        $estadisticas = [
            'total_pendientes' => CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->count(),
            'valor_total_pendiente' => CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->sum('valor'),
            'autorizadas_hoy' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                ->whereDate('updated_at', Carbon::today())
                ->count(),
            'valor_autorizado_hoy' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                ->whereDate('updated_at', Carbon::today())
                ->sum('valor'),
        ];

        return view('ordenador.autorizaciones.index', compact('autorizaciones', 'estadisticas'));
    }

    /**
     * Mostrar detalles de una autorización específica
     */
    public function showAutorizacion($id)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('ordenador')) {
            abort(403, 'Acceso denegado');
        }

        $autorizacion = CuentaCobro::with(['user'])
                                  ->findOrFail($id);

        // Solo se pueden ver cuentas aprobadas (pendientes de autorización)
        if ($autorizacion->estado !== CuentaCobro::ESTADO_APROBADO) {
            return redirect()->route('ordenador.autorizaciones.index')
                ->with('error', 'Esta cuenta no está disponible para autorización.');
        }

        // Preparar archivo
        $autorizacion->archivo_url = null;
        $autorizacion->archivo_nombre = 'Sin archivo';
        if ($autorizacion->ruta_archivo) {
            $autorizacion->archivo_url = route('cuentas-cobro.descargar', $autorizacion->id);
            $autorizacion->archivo_nombre = basename($autorizacion->ruta_archivo);
        }

        return view('ordenador.autorizaciones.show', compact('autorizacion'));
    }

    /**
     * Autorizar o rechazar una cuenta de cobro
     */
    public function autorizar(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('ordenador')) {
            abort(403, 'Acceso denegado');
        }

        $request->validate([
            'decision' => 'required|in:autorizar,rechazar',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        $cuenta = CuentaCobro::findOrFail($id);
        
        // Solo se pueden autorizar cuentas aprobadas
        if ($cuenta->estado !== CuentaCobro::ESTADO_APROBADO) {
            return redirect()->back()
                ->with('error', 'Esta cuenta no está disponible para autorización.');
        }

        $nuevoEstado = $request->decision === 'autorizar' ? CuentaCobro::ESTADO_PAGADO : CuentaCobro::ESTADO_RECHAZADO;
        
        $cuenta->update([
            'estado' => $nuevoEstado,
            'descripcion' => $request->observaciones ? 
                ($cuenta->descripcion . "\n\n--- Observaciones del Ordenador ---\n" . $request->observaciones) : 
                $cuenta->descripcion
        ]);

        $mensaje = $request->decision === 'autorizar' ? 
            'Cuenta autorizada exitosamente.' : 
            'Cuenta rechazada con observaciones.';

        return redirect()->route('ordenador.autorizaciones.index')
            ->with('success', $mensaje);
    }

    /**
     * Lista de órdenes (usando CuentaCobro como base)
     */
    public function ordenes(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('ordenador')) {
            abort(403, 'Acceso denegado');
        }

        $query = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                            ->with(['user']);

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('proyecto_servicio', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('mes')) {
            $query->whereMonth('updated_at', $request->mes);
        }

        if ($request->filled('año')) {
            $query->whereYear('updated_at', $request->año);
        }

        $ordenes = $query->orderBy('updated_at', 'desc')
                        ->paginate(25);

        // Estadísticas de órdenes
        $estadisticasOrdenes = [
            'total_ordenes' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->count(),
            'valor_total_ordenes' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->sum('valor'),
            'ordenes_mes_actual' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                ->whereMonth('updated_at', Carbon::now()->month)
                ->count(),
            'valor_mes_actual' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                ->whereMonth('updated_at', Carbon::now()->month)
                ->sum('valor'),
        ];

        return view('ordenador.ordenes.index', compact('ordenes', 'estadisticasOrdenes'));
    }

    /**
     * Mostrar detalles de una orden específica
     */
    public function showOrden($id)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('ordenador')) {
            abort(403, 'Acceso denegado');
        }

        $orden = CuentaCobro::with(['user'])
                           ->findOrFail($id);

        // Solo se pueden ver órdenes autorizadas (pagadas)
        if ($orden->estado !== CuentaCobro::ESTADO_PAGADO) {
            return redirect()->route('ordenador.ordenes.index')
                ->with('error', 'Esta orden no está disponible.');
        }

        // Preparar archivo
        $orden->archivo_url = null;
        $orden->archivo_nombre = 'Sin archivo';
        if ($orden->ruta_archivo) {
            $orden->archivo_url = route('cuentas-cobro.descargar', $orden->id);
            $orden->archivo_nombre = basename($orden->ruta_archivo);
        }

        return view('ordenador.ordenes.show', compact('orden'));
    }

    /**
     * Mostrar perfil del ordenador
     */
    public function perfil()
    {
        $user = Auth::user();
        
        if (!$user->hasRole('ordenador')) {
            abort(403, 'Acceso denegado');
        }

        // Estadísticas del usuario ordenador
        $estadisticasPersonales = [
            'total_autorizadas' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->count(),
            'valor_total_autorizado' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->sum('valor'),
            'autorizadas_este_mes' => CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                ->whereMonth('updated_at', Carbon::now()->month)
                ->count(),
            'pendientes_autorizacion' => CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->count(),
        ];

        return view('ordenador.perfil', compact('user', 'estadisticasPersonales'));
    }

    /**
     * Get evolution of authorizations per day (last 30 days)
     */
    private function getAutorizacionesPorDia()
    {
        $evolution = [];
        $now = Carbon::now();

        for ($i = 29; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dayData = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
                ->whereDate('updated_at', $date)
                ->selectRaw('COUNT(*) as count, SUM(valor) as total')
                ->first();

            $evolution[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('d/m'),
                'count' => $dayData->count ?? 0,
                'total' => $dayData->total ?? 0,
            ];
        }

        return $evolution;
    }

    /**
     * Get average daily authorizations for current month
     */
    private function getPromedioDiarioMes()
    {
        $now = Carbon::now();
        $currentDay = $now->day;
        
        $autorizacionesDelMes = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
            ->whereMonth('updated_at', $now->month)
            ->whereYear('updated_at', $now->year)
            ->count();

        return $currentDay > 0 ? round($autorizacionesDelMes / $currentDay, 1) : 0;
    }

    /**
     * Get ordenador-specific notifications
     */
    private function getOrdenadorNotifications()
    {
        $notifications = [];

        // Cuentas pendientes de autorización
        $pendientesAutorizacion = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->count();
        if ($pendientesAutorizacion > 0) {
            $notifications[] = [
                'type' => 'info',
                'icon' => 'fas fa-stamp',
                'title' => 'Pendientes de autorización',
                'message' => "Tienes {$pendientesAutorizacion} cuenta(s) pendiente(s) de autorización",
                'action' => route('ordenador.autorizaciones.index'),
                'action_text' => 'Revisar',
                'priority' => 'high'
            ];
        }

        // Cuentas aprobadas antiguas (más de 7 días)
        $antiguasPendientes = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)
            ->where('updated_at', '<=', Carbon::now()->subDays(7))
            ->count();

        if ($antiguasPendientes > 0) {
            $notifications[] = [
                'type' => 'warning',
                'icon' => 'fas fa-exclamation-triangle',
                'title' => 'Autorizaciones pendientes urgentes',
                'message' => "Hay {$antiguasPendientes} cuenta(s) aprobada(s) hace más de 7 días",
                'action' => route('ordenador.autorizaciones.index'),
                'action_text' => 'Revisar urgente',
                'priority' => 'medium'
            ];
        }

        // Autorizaciones realizadas hoy
        $autorizadasHoy = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)
            ->whereDate('updated_at', Carbon::today())
            ->count();

        if ($autorizadasHoy > 0) {
            $notifications[] = [
                'type' => 'success',
                'icon' => 'fas fa-check-circle',
                'title' => 'Autorizaciones de hoy',
                'message' => "Has autorizado {$autorizadasHoy} cuenta(s) el día de hoy",
                'action' => route('ordenador.ordenes.index'),
                'action_text' => 'Ver órdenes',
                'priority' => 'low'
            ];
        }

        // Ordenar por prioridad
        $priorityOrder = ['high' => 1, 'medium' => 2, 'low' => 3];
        usort($notifications, function($a, $b) use ($priorityOrder) {
            return $priorityOrder[$a['priority']] - $priorityOrder[$b['priority']];
        });

        return $notifications;
    }

    /**
     * API endpoint for real-time dashboard updates
     */
    public function getDashboardData()
    {
        $user = Auth::user();
        
        if (!$user->hasRole('ordenador')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $this->getOrdenadorData($user);
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'timestamp' => now()->toISOString()
        ]);
    }
}
