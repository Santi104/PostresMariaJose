<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class Reportes extends Component
{
    protected const PERIODOS = ['Hoy', 'Semana', 'Mes', 'Personalizado'];

    protected const LIMITE_TOP_PRODUCTOS = 6;

    protected const MAXIMO_DIAS_EN_GRAFICA = 62;

    public $totalVendido = 0;
    public $numeroVentas = 0;
    public $ticketPromedio = 0;
    public $periodoSeleccionado = 'Hoy';

    public $fechaInicio = '';
    public $fechaFin = '';

    public $productosMasVendidos = [];
    public $metodosPagoData = [];

    public $stockTotal = 0;
    public $productosCatalogo = 0;
    public $bajoStock = 0;
    public $agotados = 0;
    public $entradas = 0;
    public $salidas = 0;
    public $movimientosPorTipo = [];

    public $evolucion = [];
    public $tipoEvolucion = 'hora';

    protected $rangoInicio;
    protected $rangoFin;

    public function mount()
    {
        $this->generarReporte('Hoy');
    }

    public function generarReporte(string $periodo)
    {
        if (! in_array($periodo, self::PERIODOS)) {
            $periodo = 'Hoy';
        }

        $this->periodoSeleccionado = $periodo;

        if ($periodo === 'Personalizado') {
            $this->validarFechasPersonalizadas();
        }

        $this->definirRangosDeFecha($periodo);

        $this->calcularMetricasGenerales();
        $this->calcularEvolucion();
        $this->calcularTopProductos();
        $this->calcularMetodosPago();
        $this->calcularEstadoInventario();
        $this->calcularKardex();
    }

    protected function definirRangosDeFecha(string $periodo)
    {
        if ($periodo === 'Semana') {
            $this->rangoInicio = Carbon::now()->startOfWeek();
            $this->rangoFin = Carbon::now()->endOfWeek();
        } elseif ($periodo === 'Mes') {
            $this->rangoInicio = Carbon::now()->startOfMonth();
            $this->rangoFin = Carbon::now()->endOfMonth();
        } elseif ($periodo === 'Personalizado') {
            $this->rangoInicio = Carbon::parse($this->fechaInicio)->startOfDay();
            $this->rangoFin = Carbon::parse($this->fechaFin)->endOfDay();
        } else {
            $this->rangoInicio = Carbon::today()->startOfDay();
            $this->rangoFin = Carbon::today()->endOfDay();
        }
    }

    protected function validarFechasPersonalizadas()
    {
        if (empty($this->fechaInicio)) {
            $this->fechaInicio = Carbon::now()->startOfMonth()->toDateString();
        }
        if (empty($this->fechaFin)) {
            $this->fechaFin = Carbon::today()->toDateString();
        }

        $this->validate([
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
        ], [
            'fechaInicio.required' => 'Seleccione la fecha inicial.',
            'fechaInicio.date' => 'La fecha inicial no es válida.',
            'fechaFin.required' => 'Seleccione la fecha final.',
            'fechaFin.date' => 'La fecha final no es válida.',
            'fechaFin.after_or_equal' => 'La fecha final debe ser igual o posterior a la inicial.',
        ]);
    }

    protected function ventasDelPeriodo()
    {
        return Venta::where('estado', 'completada')
            ->whereBetween('fecha', [$this->rangoInicio, $this->rangoFin]);
    }

    protected function calcularMetricasGenerales()
    {
        $this->totalVendido = (float) $this->ventasDelPeriodo()->sum('total');
        $this->numeroVentas = $this->ventasDelPeriodo()->count();

        if ($this->numeroVentas > 0) {
            $this->ticketPromedio = $this->totalVendido / $this->numeroVentas;
        } else {
            $this->ticketPromedio = 0;
        }
    }

    protected function calcularEvolucion()
    {
        $totales = [];

        if ($this->periodoSeleccionado === 'Hoy') {
            $this->tipoEvolucion = 'hora';
            $formato = 'H:00';

            for ($hora = 0; $hora < 24; $hora++) {
                $totales[sprintf('%02d:00', $hora)] = 0;
            }
        } elseif ($this->rangoInicio->diffInDays($this->rangoFin) > self::MAXIMO_DIAS_EN_GRAFICA) {
            $this->tipoEvolucion = 'mes';
            $formato = 'm/Y';

            $fecha = $this->rangoInicio->copy()->startOfMonth();
            while ($fecha <= $this->rangoFin) {
                $totales[$fecha->format($formato)] = 0;
                $fecha->addMonth();
            }
        } else {
            $this->tipoEvolucion = 'dia';
            $formato = 'd/m';

            $fecha = $this->rangoInicio->copy()->startOfDay();
            while ($fecha <= $this->rangoFin) {
                $totales[$fecha->format($formato)] = 0;
                $fecha->addDay();
            }
        }

        foreach ($this->ventasDelPeriodo()->get(['fecha', 'total']) as $venta) {
            $totales[$venta->fecha->format($formato)] += (float) $venta->total;
        }

        $this->evolucion = [];

        foreach ($totales as $etiqueta => $total) {
            $this->evolucion[] = ['etiqueta' => $etiqueta, 'total' => $total];
        }
    }

    protected function calcularTopProductos()
    {
        $this->productosMasVendidos = DB::table('detalle_ventas')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->where('ventas.estado', 'completada')
            ->whereBetween('ventas.fecha', [$this->rangoInicio, $this->rangoFin])
            ->select(
                'productos.nombre',
                DB::raw('SUM(detalle_ventas.cantidad) as total_unidades'),
                DB::raw('SUM(detalle_ventas.subtotal) as total_dinero')
            )
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('total_dinero')
            ->limit(self::LIMITE_TOP_PRODUCTOS)
            ->get();
    }

    protected function calcularMetodosPago()
    {
        $this->metodosPagoData = DB::table('venta_pagos')
            ->join('ventas', 'venta_pagos.venta_id', '=', 'ventas.id')
            ->join('metodos_pago', 'venta_pagos.metodo_pago_id', '=', 'metodos_pago.id')
            ->where('ventas.estado', 'completada')
            ->whereBetween('ventas.fecha', [$this->rangoInicio, $this->rangoFin])
            ->select('metodos_pago.nombre', DB::raw('SUM(venta_pagos.monto) as total_monto'))
            ->groupBy('metodos_pago.id', 'metodos_pago.nombre')
            ->orderByDesc('total_monto')
            ->get();
    }

    protected function calcularEstadoInventario()
    {
        $productosActivos = DB::table('productos')->where('activo', 1);

        $this->stockTotal = (int) (clone $productosActivos)->where('stock_actual', '>', 0)->sum('stock_actual');
        $this->productosCatalogo = (clone $productosActivos)->count();

        $this->bajoStock = (clone $productosActivos)
            ->where('stock_actual', '>', 0)
            ->whereColumn('stock_actual', '<=', 'stock_minimo')
            ->count();

        $this->agotados = (clone $productosActivos)->where('stock_actual', '<=', 0)->count();
    }

    protected function calcularKardex()
    {
        $movimientos = DB::table('movimientos_inventario')
            ->whereBetween('fecha', [$this->rangoInicio, $this->rangoFin]);

        $this->entradas = (int) (clone $movimientos)
            ->whereColumn('stock_resultante', '>', 'stock_anterior')
            ->sum('cantidad');

        $this->salidas = (int) (clone $movimientos)
            ->whereColumn('stock_resultante', '<', 'stock_anterior')
            ->sum('cantidad');

        $this->movimientosPorTipo = (clone $movimientos)
            ->select('tipo', DB::raw('SUM(cantidad) as total'))
            ->groupBy('tipo')
            ->orderByDesc('total')
            ->get();
    }

    public function exportarPDF()
    {
        $this->generarReporte($this->periodoSeleccionado);

        $pdf = Pdf::loadView('pdf.reporte-ventas', [
            'periodo' => $this->periodoSeleccionado,
            'desde' => $this->rangoInicio,
            'hasta' => $this->rangoFin,
            'totalVendido' => $this->totalVendido,
            'numeroVentas' => $this->numeroVentas,
            'ticketPromedio' => $this->ticketPromedio,
            'evolucion' => $this->evolucion,
            'tipoEvolucion' => $this->tipoEvolucion,
            'productosMasVendidos' => $this->productosMasVendidos,
            'metodosPagoData' => $this->metodosPagoData,
            'stockTotal' => $this->stockTotal,
            'productosCatalogo' => $this->productosCatalogo,
            'bajoStock' => $this->bajoStock,
            'agotados' => $this->agotados,
            'entradas' => $this->entradas,
            'salidas' => $this->salidas,
            'movimientosPorTipo' => $this->movimientosPorTipo,
            'ventas' => $this->ventasDelPeriodo()->orderBy('fecha')->get(),
        ]);

        $nombreArchivo = 'Reporte_' . $this->periodoSeleccionado . '_' . $this->rangoInicio->format('Y-m-d') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $nombreArchivo);
    }

    public function render()
    {
        return view('livewire.reportes');
    }
}
