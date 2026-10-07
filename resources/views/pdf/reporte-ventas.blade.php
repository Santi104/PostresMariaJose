<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte {{ $periodo }} — Postres María José</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #241C1B; margin: 0; }
    h1 { font-size: 20px; margin: 0; color: #C8102E; }
    h2 { font-size: 13px; margin: 18px 0 6px; padding-bottom: 4px; border-bottom: 2px solid #C8102E; }
    .sub { color: #8A7E7C; margin-top: 3px; }
    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; font-size: 10px; text-transform: uppercase; color: #8A7E7C; padding: 5px 6px; border-bottom: 1px solid #E3DEDB; }
    td { padding: 5px 6px; border-bottom: 1px solid #F1EEED; }
    .num { text-align: right; }
    .kpi td { border: 1px solid #E3DEDB; padding: 8px 10px; width: 25%; }
    .kpi .etiqueta { font-size: 9.5px; text-transform: uppercase; color: #8A7E7C; }
    .kpi .valor { font-size: 16px; font-weight: bold; margin-top: 2px; }
    .vacio { color: #8A7E7C; padding: 8px 6px; }
    .pie { margin-top: 20px; font-size: 9px; color: #B0A6A4; text-align: center; }
</style>
</head>
<body>
@php
    $moneda = fn ($valor) => '$' . number_format($valor, 0, ',', '.');
    $nombresTipo = [
        'produccion' => 'Producción',
        'salida' => 'Venta',
        'ajuste' => 'Ajuste / Merma',
        'entrada' => 'Entrada externa',
        'anulacion' => 'Anulación (Devolución)',
    ];
    $totalRecaudado = collect($metodosPagoData)->sum('total_monto');
@endphp

<h1>Postres María José</h1>
<div class="sub">
    Reporte de ventas e inventario · {{ $periodo }}:
    @if($desde->isSameDay($hasta))
        {{ $desde->format('d/m/Y') }}
    @else
        del {{ $desde->format('d/m/Y') }} al {{ $hasta->format('d/m/Y') }}
    @endif
</div>

<h2>1. Ventas del período</h2>
<table class="kpi">
    <tr>
        <td><div class="etiqueta">Total vendido</div><div class="valor">{{ $moneda($totalVendido) }}</div></td>
        <td><div class="etiqueta">Número de ventas</div><div class="valor">{{ $numeroVentas }}</div></td>
        <td><div class="etiqueta">Ticket promedio</div><div class="valor">{{ $moneda($ticketPromedio) }}</div></td>
        <td><div class="etiqueta">Recaudado</div><div class="valor">{{ $moneda($totalRecaudado) }}</div></td>
    </tr>
</table>

@php
    $columnaEvolucion = ['hora' => 'Hora', 'dia' => 'Día', 'mes' => 'Mes'][$tipoEvolucion];
    $evolucionConVentas = collect($evolucion)->where('total', '>', 0);
    $maxEvolucion = $evolucionConVentas->max('total');
@endphp
<table style="margin-top:8px">
    <tr><th>{{ $columnaEvolucion }}</th><th class="num">Total</th><th style="width:50%"></th></tr>
    @forelse($evolucionConVentas as $punto)
        <tr>
            <td>{{ $punto['etiqueta'] }}</td>
            <td class="num">{{ $moneda($punto['total']) }}</td>
            <td><div style="height:8px; width:{{ ($punto['total'] / $maxEvolucion) * 100 }}%; background:#C8102E;"></div></td>
        </tr>
    @empty
        <tr><td colspan="3" class="vacio">Sin ventas en este período.</td></tr>
    @endforelse
</table>

<h2>2. Productos más vendidos</h2>
<table>
    <tr><th>Producto</th><th class="num">Unidades</th><th class="num">Total</th></tr>
    @forelse($productosMasVendidos as $producto)
        <tr>
            <td>{{ $producto->nombre }}</td>
            <td class="num">{{ $producto->total_unidades }}</td>
            <td class="num">{{ $moneda($producto->total_dinero) }}</td>
        </tr>
    @empty
        <tr><td colspan="3" class="vacio">No hay productos vendidos en este período.</td></tr>
    @endforelse
</table>

<h2>3. Métodos de pago</h2>
<table>
    <tr><th>Método</th><th class="num">Monto</th><th class="num">%</th></tr>
    @forelse($metodosPagoData as $metodo)
        <tr>
            <td>{{ $metodo->nombre }}</td>
            <td class="num">{{ $moneda($metodo->total_monto) }}</td>
            <td class="num">{{ $totalRecaudado > 0 ? round(($metodo->total_monto / $totalRecaudado) * 100) : 0 }}%</td>
        </tr>
    @empty
        <tr><td colspan="3" class="vacio">Sin pagos registrados.</td></tr>
    @endforelse
</table>

<h2>4. Inventario</h2>
<table class="kpi">
    <tr>
        <td><div class="etiqueta">Unidades en stock</div><div class="valor">{{ number_format($stockTotal, 0, ',', '.') }}</div><div class="sub">{{ $productosCatalogo }} productos en catálogo</div></td>
        <td><div class="etiqueta">En bajo stock</div><div class="valor">{{ $bajoStock }}</div></td>
        <td><div class="etiqueta">Agotados</div><div class="valor">{{ $agotados }}</div></td>
        <td><div class="etiqueta">Movimientos (und)</div><div class="valor">{{ $entradas + $salidas }}</div><div class="sub">↑ {{ $entradas }} entradas · ↓ {{ $salidas }} salidas</div></td>
    </tr>
</table>
<table style="margin-top:8px">
    <tr><th>Movimiento</th><th class="num">Unidades</th></tr>
    @forelse($movimientosPorTipo as $mov)
        <tr>
            <td>{{ $nombresTipo[$mov->tipo] ?? $mov->tipo }}</td>
            <td class="num">{{ $mov->total }}</td>
        </tr>
    @empty
        <tr><td colspan="2" class="vacio">No hay registros de movimientos.</td></tr>
    @endforelse
</table>

<h2>Detalle de ventas</h2>
<table>
    <tr><th>Número</th><th>Fecha</th><th class="num">Total</th></tr>
    @forelse($ventas as $venta)
        <tr>
            <td>{{ $venta->numero }}</td>
            <td>{{ $venta->fecha->format('d/m/Y H:i') }}</td>
            <td class="num">{{ $moneda($venta->total) }}</td>
        </tr>
    @empty
        <tr><td colspan="3" class="vacio">No hay ventas completadas en este período.</td></tr>
    @endforelse
</table>

<div class="pie">Generado el {{ now()->format('d/m/Y H:i') }} · Las ventas anuladas no se incluyen.</div>
</body>
</html>
