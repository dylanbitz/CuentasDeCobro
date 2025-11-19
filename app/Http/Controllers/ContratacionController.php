<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CuentaCobro;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ContratoRequest;

class ContratacionController extends Controller
{
    /**
     * Display contratacion dashboard with real data
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Verificar que el usuario sea de contratación
        if (!$user || !$user->hasRole('contratacion')) {
            abort(403, 'Acceso denegado. Solo el personal de contratación puede acceder a esta vista.');
        }

        // Obtener datos del dashboard
        $data = $this->getContratacionData();
        
        return view('contratacion.dashboard', array_merge($data, [
            'user' => $user
        ]));
    }

    /**
     * Get all contratacion-specific data
     */
    private function getContratacionData()
    {
        $now = Carbon::now();

        // Estadísticas principales usando CuentaCobro como base de contratos
        $totalContratos = CuentaCobro::count();
        $contratosPendientes = CuentaCobro::where('estado', CuentaCobro::ESTADO_PENDIENTE)->count();
        $contratosEnRevision = CuentaCobro::where('estado', CuentaCobro::ESTADO_REVISION)->count();
        $contratosAprobados = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->count();
        $contratosPagados = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->count();
        $contratosRechazados = CuentaCobro::where('estado', CuentaCobro::ESTADO_RECHAZADO)->count();
        $contratosBorrador = CuentaCobro::where('estado', CuentaCobro::ESTADO_BORRADOR)->count();

        // Valores monetarios
        $valorTotalContratos = CuentaCobro::sum('valor') ?? 0;
        $valorPendiente = CuentaCobro::where('estado', CuentaCobro::ESTADO_PENDIENTE)->sum('valor') ?? 0;
        $valorEnRevision = CuentaCobro::where('estado', CuentaCobro::ESTADO_REVISION)->sum('valor') ?? 0;
        $valorAprobado = CuentaCobro::where('estado', CuentaCobro::ESTADO_APROBADO)->sum('valor') ?? 0;
        $valorPagado = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->sum('valor') ?? 0;

        // Contratistas/Proveedores activos
        $contratistaRole = Roles::where('name', 'contratista')->first();
        $totalProveedores = $contratistaRole ? User::where('role_id', $contratistaRole->id)->count() : 0;
        
        $proveedoresActivos = User::whereHas('cuentasCobro', function($query) use ($now) {
            $query->where('created_at', '>=', $now->subDays(30));
        })->count();
        
        // Estadísticas calculadas
        $contratosActivos = $contratosEnRevision + $contratosAprobados;
        $promedioPorContrato = $totalContratos > 0 ? $valorTotalContratos / $totalContratos : 0;
        
        $proximosVencer = CuentaCobro::where('created_at', '<', $now->subDays(7))
            ->whereIn('estado', [CuentaCobro::ESTADO_PENDIENTE, CuentaCobro::ESTADO_REVISION])
            ->count();

        $contratosEsteMes = CuentaCobro::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();
        
        $valorEsteMes = CuentaCobro::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('valor') ?? 0;

        // Estadísticas combinadas
        $stats = [
            'total_contratos' => $totalContratos,
            'contratos_activos' => $contratosActivos,
            'valor_total' => $valorTotalContratos,
            'promedio_valor' => $promedioPorContrato,
            'proveedores_activos' => $proveedoresActivos,
            'proximos_vencer' => $proximosVencer,
            'contratos_pendientes' => $contratosPendientes,
            'contratos_aprobados' => $contratosAprobados,
            'contratos_pagados' => $contratosPagados,
            'contratos_este_mes' => $contratosEsteMes,
            'valor_este_mes' => $valorEsteMes,
            'total_proveedores' => $totalProveedores
        ];

        // Contratos por mes (últimos 6 meses)
        $contratosPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $count = CuentaCobro::whereMonth('created_at', $fecha->month)
                              ->whereYear('created_at', $fecha->year)
                              ->count();
            $valor = CuentaCobro::whereMonth('created_at', $fecha->month)
                              ->whereYear('created_at', $fecha->year)
                              ->sum('valor') ?? 0;
            $contratosPorMes[] = [
                'mes' => $fecha->locale('es')->format('M Y'),
                'count' => $count,
                'valor' => $valor
            ];
        }

        // Últimos contratos creados
        $ultimosContratos = CuentaCobro::with(['user' => function($query) {
                $query->select('id', 'name', 'email');
            }])
            ->select('id', 'user_id', 'proyecto_servicio', 'valor', 'estado', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Contratos por estado para gráfico
        $contratosPorEstado = [
            ['estado' => 'Borrador', 'count' => $contratosBorrador, 'color' => '#9ca3af'],
            ['estado' => 'Pendiente', 'count' => $contratosPendientes, 'color' => '#f59e0b'],
            ['estado' => 'En Revisión', 'count' => $contratosEnRevision, 'color' => '#3b82f6'],
            ['estado' => 'Aprobado', 'count' => $contratosAprobados, 'color' => '#10b981'],
            ['estado' => 'Pagado', 'count' => $contratosPagados, 'color' => '#8b5cf6'],
            ['estado' => 'Rechazado', 'count' => $contratosRechazados, 'color' => '#ef4444']
        ];

        // Notificaciones
        $notificaciones = $this->getContratacionNotifications();

        return compact(
            'stats',
            'totalContratos',
            'contratosPendientes', 
            'contratosEnRevision',
            'contratosAprobados',
            'contratosPagados',
            'contratosRechazados',
            'contratosBorrador',
            'valorTotalContratos',
            'valorPendiente',
            'valorEnRevision',
            'valorAprobado',
            'valorPagado',
            'totalProveedores',
            'proveedoresActivos',
            'contratosPorMes',
            'ultimosContratos',
            'contratosPorEstado',
            'notificaciones'
        );
    }

    /**
     * Get contratacion notifications
     */
    private function getContratacionNotifications()
    {
        $notifications = [];
        $now = Carbon::now();

        $cuentasPendientes = CuentaCobro::where('estado', CuentaCobro::ESTADO_PENDIENTE)->count();
        if ($cuentasPendientes > 0) {
            $notifications[] = [
                'tipo' => 'warning',
                'mensaje' => "Hay {$cuentasPendientes} cuentas de cobro pendientes de revisión",
                'icono' => 'fa-clock',
                'url' => route('contratacion.contratos.index', ['estado' => 'pendiente'])
            ];
        }

        $cuentasEnRevisionVencidas = CuentaCobro::where('estado', CuentaCobro::ESTADO_REVISION)
            ->where('updated_at', '<', $now->subDays(5))
            ->count();
        if ($cuentasEnRevisionVencidas > 0) {
            $notifications[] = [
                'tipo' => 'warning',
                'mensaje' => "Hay {$cuentasEnRevisionVencidas} cuentas en revisión por más de 5 días",
                'icono' => 'fa-hourglass-half',
                'url' => route('contratacion.contratos.index', ['estado' => 'revision'])
            ];
        }

        return $notifications;
    }

    /**
     * Lista de contratos con filtros y paginación
     */
    public function contratosIndex(Request $request)
    {
        $query = CuentaCobro::with(['user' => function($query) {
            $query->select('id', 'name', 'email');
        }]);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('proyecto_servicio', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('proveedor_id')) {
            $query->where('user_id', $request->proveedor_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $query->orderBy('created_at', 'desc');
        $contratos = $query->paginate(15);

        // Datos auxiliares
        $estados = CuentaCobro::getEstados();
        $proveedores = User::whereHas('role', function($query) {
            $query->where('name', 'contratista');
        })->select('id', 'name')->get();

        $stats = [
            'total_contratos' => CuentaCobro::count(),
            'valor_total' => CuentaCobro::sum('valor') ?? 0,
            'promedio_valor' => CuentaCobro::avg('valor') ?? 0
        ];

        return view('contratacion.contratos.index', compact(
            'contratos',
            'estados', 
            'proveedores',
            'stats'
        ));
    }    /**
     * Mostrar formulario para crear nuevo contrato
     */
    public function contratosCreate()
    {
        $proveedores = User::whereHas('role', function($query) {
            $query->where('name', 'contratista');
        })->select('id', 'name', 'email')->orderBy('name')->get();

        $estados = CuentaCobro::getEstados();

        return view('contratacion.contratos.create', compact('proveedores', 'estados'));
    }/**
     * Almacenar nuevo contrato
     */
    public function contratosStore(ContratoRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('ruta_archivo')) {
            $file = $request->file('ruta_archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('cuentas_cobro', $filename, 'public');
            $validated['ruta_archivo'] = $path;
        }

        $cuentaCobro = CuentaCobro::create($validated);

        return redirect()->route('contratacion.contratos.index')
            ->with('success', 'Cuenta de cobro creada exitosamente.');
    }

    /**
     * Mostrar detalle de un contrato específico
     */
    public function contratosShow($id)
    {
        $contrato = CuentaCobro::with(['user'])->findOrFail($id);
        return view('contratacion.contratos.show', compact('contrato'));
    }    /**
     * Mostrar formulario para editar contrato
     */
    public function contratosEdit($id)
    {
        $contrato = CuentaCobro::with(['user'])->findOrFail($id);
        
        $proveedores = User::whereHas('role', function($query) {
            $query->where('name', 'contratista');
        })->select('id', 'name', 'email')->orderBy('name')->get();

        $estados = CuentaCobro::getEstados();

        return view('contratacion.contratos.edit', compact('contrato', 'proveedores', 'estados'));
    }/**
     * Actualizar contrato
     */
    public function contratosUpdate(ContratoRequest $request, $id)
    {
        $contrato = CuentaCobro::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('ruta_archivo')) {
            if ($contrato->ruta_archivo && Storage::disk('public')->exists($contrato->ruta_archivo)) {
                Storage::disk('public')->delete($contrato->ruta_archivo);
            }
            
            $file = $request->file('ruta_archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('cuentas_cobro', $filename, 'public');
            $validated['ruta_archivo'] = $path;
        }

        $contrato->update($validated);

        return redirect()->route('contratacion.contratos.show', $contrato->id)
            ->with('success', 'Cuenta de cobro actualizada exitosamente.');
    }

    /**
     * Eliminar contrato
     */
    public function contratosDestroy($id)
    {
        $contrato = CuentaCobro::findOrFail($id);

        if (!$contrato->sePuedeEliminar()) {
            return redirect()->back()
                ->with('error', 'Esta cuenta de cobro no se puede eliminar en su estado actual.');
        }

        if ($contrato->ruta_archivo && Storage::disk('public')->exists($contrato->ruta_archivo)) {
            Storage::disk('public')->delete($contrato->ruta_archivo);
        }

        $contrato->delete();

        return redirect()->route('contratacion.contratos.index')
            ->with('success', 'Cuenta de cobro eliminada exitosamente.');
    }

    /**
     * Lista de procesos de contratación
     */    public function procesosIndex(Request $request)
    {
        $procesos = CuentaCobro::select('estado', DB::raw('count(*) as total'), DB::raw('sum(valor) as valor_total'))
            ->groupBy('estado')
            ->get()
            ->map(function($proceso) {
                // Configuración de estados con sus propiedades visuales
                $estadosConfig = [
                    CuentaCobro::ESTADO_BORRADOR => [
                        'color_gradient' => 'from-gray-500 to-slate-500',
                        'color' => 'gray',
                        'icono' => 'fas fa-edit',
                        'descripcion' => 'En edición/borrador'
                    ],
                    CuentaCobro::ESTADO_PENDIENTE => [
                        'color_gradient' => 'from-yellow-500 to-orange-500',
                        'color' => 'yellow',
                        'icono' => 'fas fa-clock',
                        'descripcion' => 'Pendientes de revisión'
                    ],
                    CuentaCobro::ESTADO_REVISION => [
                        'color_gradient' => 'from-blue-500 to-indigo-500',
                        'color' => 'blue',
                        'icono' => 'fas fa-search',
                        'descripcion' => 'En proceso de revisión'
                    ],
                    CuentaCobro::ESTADO_APROBADO => [
                        'color_gradient' => 'from-green-500 to-emerald-500',
                        'color' => 'green',
                        'icono' => 'fas fa-check-circle',
                        'descripcion' => 'Aprobados para pago'
                    ],
                    CuentaCobro::ESTADO_RECHAZADO => [
                        'color_gradient' => 'from-red-500 to-rose-500',
                        'color' => 'red',
                        'icono' => 'fas fa-times-circle',
                        'descripcion' => 'Rechazados por errores'
                    ],
                    CuentaCobro::ESTADO_PAGADO => [
                        'color_gradient' => 'from-purple-500 to-pink-500',
                        'color' => 'purple',
                        'icono' => 'fas fa-money-check',
                        'descripcion' => 'Pagados exitosamente'
                    ]
                ];

                $config = $estadosConfig[$proceso->estado] ?? [
                    'color_gradient' => 'from-gray-500 to-slate-500',
                    'color' => 'gray',
                    'icono' => 'fas fa-question-circle',
                    'descripcion' => 'Estado desconocido'
                ];                // Obtener contratos de este estado (convertir a array para la vista)
                $contratos = CuentaCobro::where('estado', $proceso->estado)
                    ->with(['user'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->toArray();

                // Calcular proveedores únicos
                $proveedoresUnicos = CuentaCobro::where('estado', $proceso->estado)
                    ->distinct('user_id')
                    ->count('user_id');

                // Calcular porcentaje (basado en el total de contratos del sistema)
                $totalContratos = CuentaCobro::count();
                $porcentaje = $totalContratos > 0 ? round(($proceso->total / $totalContratos) * 100, 1) : 0;

                return [
                    'id' => $proceso->estado,
                    'nombre' => CuentaCobro::getEstados()[$proceso->estado] ?? $proceso->estado,
                    'estado' => $proceso->estado,
                    'filtro_estado' => $proceso->estado,
                    'total_contratos' => $proceso->total,
                    'valor_total' => $proceso->valor_total ?? 0,
                    'color_gradient' => $config['color_gradient'],
                    'color' => $config['color'],
                    'icono' => $config['icono'],
                    'descripcion' => $config['descripcion'],
                    'contratos' => $contratos,
                    'proveedores_unicos' => $proveedoresUnicos,
                    'porcentaje' => $porcentaje,
                    'updated_at' => Carbon::now(),
                ];
            });

        $procesosPorEstado = [];
        foreach (CuentaCobro::getEstados() as $estadoKey => $estadoNombre) {
            $procesosPorEstado[$estadoKey] = CuentaCobro::where('estado', $estadoKey)->get();
        }

        $procesosCompletados = CuentaCobro::where('estado', CuentaCobro::ESTADO_PAGADO)->count();
        $valorTotal = CuentaCobro::sum('valor') ?? 0;

        $proveedores = \App\Models\User::whereHas('role', function($query) {
            $query->where('name', 'contratista');
        })->select('id', 'name')->get();

        $procesosRecientes = \App\Models\CuentaCobro::orderBy('created_at', 'desc')->limit(8)->get();

        return view('contratacion.procesos.index', compact('procesos', 'procesosCompletados', 'valorTotal', 'proveedores', 'procesosPorEstado', 'procesosRecientes'));
    }

    /**
     * Mostrar detalle del proceso
     */    public function procesosShow($estado)
    {
        $nombreProceso = CuentaCobro::getEstados()[$estado] ?? $estado;
        
        $contratos = CuentaCobro::with(['user'])
            ->where('estado', $estado)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $estadisticas = [
            'total_contratos' => $contratos->total(),
            'valor_total' => CuentaCobro::where('estado', $estado)->sum('valor'),
            'promedio_dias' => CuentaCobro::where('estado', $estado)
                ->avg(DB::raw('DATEDIFF(NOW(), created_at)')),
        ];

        return view('contratacion.procesos.show', compact('contratos', 'nombreProceso', 'estado', 'estadisticas'));
    }

    /**
     * Lista de proveedores
     */
    public function proveedoresIndex(Request $request)
    {
        $contratistaRole = Roles::where('name', 'contratista')->first();
        
        if (!$contratistaRole) {
            return view('contratacion.proveedores.index', ['proveedores' => collect(), 'stats' => []]);
        }        $query = User::where('role_id', $contratistaRole->id)
            ->withCount(['cuenta_cobros'])
            ->withSum('cuenta_cobros', 'valor');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->paginate(25);        $stats = [
            'total_proveedores' => User::where('role_id', $contratistaRole->id)->count(),
            'proveedores_activos' => User::where('role_id', $contratistaRole->id)
                ->whereHas('cuenta_cobros', function($q) {
                    $q->where('created_at', '>=', Carbon::now()->subMonths(6));
                })->count(),
        ];

        return view('contratacion.proveedores.index', compact('proveedores', 'stats'));
    }

    /**
     * Mostrar detalle del proveedor
     */
    public function proveedoresShow($id)
    {
        $contratistaRole = Roles::where('name', 'contratista')->first();
        $proveedor = User::where('role_id', $contratistaRole->id)
            ->findOrFail($id);

        $contratos = CuentaCobro::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);        $estadisticas = [
            'total_contratos' => $proveedor->cuenta_cobros()->count(),
            'valor_total' => $proveedor->cuenta_cobros()->sum('valor'),
            'contratos_activos' => $proveedor->cuenta_cobros()
                ->whereIn('estado', [CuentaCobro::ESTADO_PENDIENTE, CuentaCobro::ESTADO_REVISION])
                ->count(),
            'ultimo_contrato' => $proveedor->cuenta_cobros()->latest()->first()?->created_at,
        ];

        return view('contratacion.proveedores.show', compact('proveedor', 'contratos', 'estadisticas'));
    }

    /**
     * Mostrar perfil del usuario de contratación
     */
    public function perfil()
    {
        $user = Auth::user();
        
        $stats = [
            'contratos_gestionados' => CuentaCobro::count(),
            'valor_total_gestionado' => CuentaCobro::sum('valor'),
            'proveedores_activos' => User::whereHas('role', function($q) {
                $q->where('name', 'contratista');
            })->count(),
            'contratos_este_mes' => CuentaCobro::whereMonth('created_at', Carbon::now()->month)->count(),
        ];

        $actividad_reciente = CuentaCobro::with(['user'])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($contrato) {
                return [
                    'descripcion' => "Contrato actualizado: {$contrato->proyecto_servicio}",
                    'tiempo' => $contrato->updated_at->diffForHumans(),
                    'valor' => $contrato->valor,
                    'contrato_id' => $contrato->id,
                    'color' => $contrato->color_estado,
                    'icon' => $contrato->icono_estado,
                ];
            });

        return view('contratacion.perfil', compact('user', 'stats', 'actividad_reciente'));
    }

    /**
     * API endpoint para datos del dashboard
     */
    public function getContratacionApiData()
    {
        $data = $this->getContratacionData();
        return response()->json($data);
    }
}
