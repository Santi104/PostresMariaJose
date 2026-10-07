<section style="flex:1; min-width:0; overflow-y:auto; padding:22px 26px 34px; position:relative; display:flex; flex-direction:column; gap:20px; background:#F6F5F4;">

  <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap">
    <div style="display:flex; flex-wrap:wrap; gap:8px; background:#EFEDEC; border-radius:18px; padding:5px">
      <button wire:click="generarReporte('Hoy')" style="height:44px; padding:0 20px; border-radius:14px; border:none; font-size:15px; font-weight:600; cursor:pointer; transition: all 0.2s; background: {{ $periodoSeleccionado == 'Hoy' ? '#C8102E' : 'transparent' }}; color: {{ $periodoSeleccionado == 'Hoy' ? '#fff' : '#4A3F3D' }};">Hoy</button>
      
      <button wire:click="generarReporte('Semana')" style="height:44px; padding:0 20px; border-radius:14px; border:none; font-size:15px; font-weight:600; cursor:pointer; transition: all 0.2s; background: {{ $periodoSeleccionado == 'Semana' ? '#C8102E' : 'transparent' }}; color: {{ $periodoSeleccionado == 'Semana' ? '#fff' : '#4A3F3D' }};">Semana</button>
      
      <button wire:click="generarReporte('Mes')" style="height:44px; padding:0 20px; border-radius:14px; border:none; font-size:15px; font-weight:600; cursor:pointer; transition: all 0.2s; background: {{ $periodoSeleccionado == 'Mes' ? '#C8102E' : 'transparent' }}; color: {{ $periodoSeleccionado == 'Mes' ? '#fff' : '#4A3F3D' }};">Mes</button>

      <button wire:click="generarReporte('Personalizado')" style="height:44px; padding:0 20px; border-radius:14px; border:none; font-size:15px; font-weight:600; cursor:pointer; transition: all 0.2s; background: {{ $periodoSeleccionado == 'Personalizado' ? '#C8102E' : 'transparent' }}; color: {{ $periodoSeleccionado == 'Personalizado' ? '#fff' : '#4A3F3D' }};">Personalizado</button>
    </div>

    @if($periodoSeleccionado == 'Personalizado')
    <div style="display:flex; flex-direction:column; gap:6px">
      <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap">
        <input type="date" wire:model="fechaInicio" aria-label="Fecha inicial" style="height:44px; padding:0 12px; border-radius:14px; border:1px solid rgba(36,28,27,.14); background:#fff; color:#241C1B; font-size:15px; font-weight:600;">
        <span style="font-size:14px; font-weight:600; color:#8A7E7C">a</span>
        <input type="date" wire:model="fechaFin" aria-label="Fecha final" style="height:44px; padding:0 12px; border-radius:14px; border:1px solid rgba(36,28,27,.14); background:#fff; color:#241C1B; font-size:15px; font-weight:600;">
        <button wire:click="generarReporte('Personalizado')" style="height:44px; padding:0 18px; border-radius:14px; border:none; background:#241C1B; color:#fff; font-size:15px; font-weight:600; cursor:pointer;">Aplicar</button>
      </div>
      @error('fechaInicio') <span style="font-size:13px; font-weight:600; color:#96001F">{{ $message }}</span> @enderror
      @error('fechaFin') <span style="font-size:13px; font-weight:600; color:#96001F">{{ $message }}</span> @enderror
    </div>
    @endif

    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap">
      <button wire:click="exportarPDF" wire:loading.attr="disabled" wire:target="exportarPDF" style="height:52px; padding:0 22px; border-radius:17px; border:none; background:#C8102E; color:#fff; font-size:15.5px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; display:flex; align-items:center; gap:9px; box-shadow:0 10px 24px rgba(200,16,46,.28); cursor:pointer;"><span class="material-symbols-rounded" style="font-size:22px">ios_share</span>Exportar</button>
    </div>
  </div>

  <div style="display:flex; flex-direction:column; gap:12px">
    <div style="display:flex; align-items:center; gap:11px">
      <span style="width:28px; height:28px; flex:none; border-radius:9px; background:#C8102E; color:#fff; font-size:14px; font-weight:800; display:flex; align-items:center; justify-content:center">1</span>
      <div style="font-size:19px; font-weight:700; letter-spacing:-.3px; color:#241C1B;">Ventas del período</div>
    </div>
    <div style="background:#fff; border:1px solid rgba(36,28,27,.07); border-radius:26px; padding:22px 24px; box-shadow:0 2px 10px rgba(36,28,27,.045); display:flex; flex-wrap:wrap; gap:24px; align-items:stretch">
      <div style="flex:0 1 240px; min-width:0; display:flex; flex-direction:column; gap:14px">
        <div>
          <div style="font-size:12.5px; font-weight:800; letter-spacing:.07em; text-transform:uppercase; color:#8A7E7C">Total vendido</div>
          <div style="font-size:clamp(24px, 7vw, 44px); font-weight:800; letter-spacing:-2px; line-height:1; font-variant-numeric:tabular-nums; margin-top:4px; color:#241C1B;">${{ number_format($totalVendido, 0, ',', '.') }}</div>
        </div>
        <div style="padding-top:14px; border-top:1px dashed rgba(36,28,27,.14); display:flex; flex-direction:column; gap:10px">
          <div>
            <div style="font-size:12.5px; font-weight:700; color:#8A7E7C">Número de ventas</div>
            <div style="font-size:30px; font-weight:800; letter-spacing:-1.2px; line-height:1.05; font-variant-numeric:tabular-nums; color:#241C1B;">{{ $numeroVentas }}</div>
          </div>
          <div>
            <div style="font-size:12.5px; font-weight:700; color:#8A7E7C">Ticket promedio</div>
            <div style="font-size:22px; font-weight:800; letter-spacing:-.8px; line-height:1.05; font-variant-numeric:tabular-nums; color:#241C1B;">${{ number_format($ticketPromedio, 0, ',', '.') }}</div>
          </div>
        </div>
      </div>
      @php
          $titulosEvolucion = ['hora' => 'Ventas por hora', 'dia' => 'Ventas por día', 'mes' => 'Ventas por mes'];
          $maxEvolucion = collect($evolucion)->max('total');
          $etiquetasEje = [];
          if (count($evolucion) > 0) {
              $etiquetasEje = array_unique([
                  $evolucion[0]['etiqueta'],
                  $evolucion[intdiv(count($evolucion), 2)]['etiqueta'],
                  $evolucion[count($evolucion) - 1]['etiqueta'],
              ]);
          }
      @endphp
      <div style="flex:1 1 200px; min-width:0; display:flex; flex-direction:column; gap:10px; background:#F9F9F9; border-radius:16px; padding:14px 16px;">
        <div style="font-size:12.5px; font-weight:800; letter-spacing:.07em; text-transform:uppercase; color:#8A7E7C">{{ $titulosEvolucion[$tipoEvolucion] }}</div>
        @if($maxEvolucion > 0)
          <div style="overflow-x:auto; padding-bottom:4px">
            <div style="min-width:{{ count($evolucion) * 10 }}px; display:flex; flex-direction:column; gap:10px">
              <div style="height:140px; display:flex; align-items:flex-end; gap:2px; border-bottom:1px solid rgba(36,28,27,.14)">
                @foreach($evolucion as $punto)
                  <div title="{{ $punto['etiqueta'] }} · ${{ number_format($punto['total'], 0, ',', '.') }}" style="flex:1; min-width:8px; height:{{ ($punto['total'] / $maxEvolucion) * 100 }}%; background:#C8102E; border-radius:4px 4px 0 0"></div>
                @endforeach
              </div>
              <div style="display:flex; justify-content:space-between; gap:8px; font-size:11px; font-weight:600; color:#8A7E7C; font-variant-numeric:tabular-nums">
                @foreach($etiquetasEje as $etiqueta)
                  <span>{{ $etiqueta }}</span>
                @endforeach
              </div>
            </div>
          </div>
        @else
          <div style="min-height:80px; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:600; color:#B0A6A4;">Sin ventas en este período.</div>
        @endif
      </div>
    </div>
  </div>

  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(min(340px, 100%), 1fr)); gap:20px; align-items:start">
    
    <div style="display:flex; flex-direction:column; gap:12px">
      <div style="display:flex; align-items:center; gap:11px">
        <span style="width:28px; height:28px; flex:none; border-radius:9px; background:#C8102E; color:#fff; font-size:14px; font-weight:800; display:flex; align-items:center; justify-content:center">2</span>
        <div style="font-size:19px; font-weight:700; letter-spacing:-.3px; color:#241C1B;">Productos más vendidos</div>
      </div>
      <div style="background:#fff; border:1px solid rgba(36,28,27,.07); border-radius:26px; padding:20px 22px; box-shadow:0 2px 10px rgba(36,28,27,.045); display:flex; flex-direction:column; gap:14px">
        @php
            $maxDinero = count($productosMasVendidos) > 0 ? collect($productosMasVendidos)->max('total_dinero') : 1;
            $colores = ['#C8102E', '#D8324B', '#E04A65', '#EE8B9D', '#F3AFBB', '#F6C3CC'];
        @endphp

        @forelse($productosMasVendidos as $index => $producto)
        <div style="display:flex; flex-direction:column; gap:6px">
          <div style="display:flex; flex-wrap:wrap; align-items:baseline; gap:10px; color:#241C1B;">
            <span style="flex:1 1 120px; min-width:0; font-size:14.5px; font-weight:600">{{ $producto->nombre }}</span>
            <span style="font-size:13px; font-weight:600; color:#8A7E7C; font-variant-numeric:tabular-nums">{{ $producto->total_unidades }} und</span>
            <span style="font-size:16px; font-weight:800; font-variant-numeric:tabular-nums; min-width:78px; text-align:right">${{ number_format($producto->total_dinero, 0, ',', '.') }}</span>
          </div>
          <div style="height:12px; border-radius:6px; background:#F1EEED; overflow:hidden">
            <div style="height:100%; width:{{ ($producto->total_dinero / $maxDinero) * 100 }}%; border-radius:6px; background:{{ $colores[$index % 6] }}"></div>
          </div>
        </div>
        @empty
        <div style="text-align:center; padding: 20px 0; color:#8A7E7C; font-size:14px; font-weight:600;">No hay productos vendidos en este período.</div>
        @endforelse
      </div>
    </div>

    <div style="display:flex; flex-direction:column; gap:12px">
      <div style="display:flex; align-items:center; gap:11px">
        <span style="width:28px; height:28px; flex:none; border-radius:9px; background:#C8102E; color:#fff; font-size:14px; font-weight:800; display:flex; align-items:center; justify-content:center">3</span>
        <div style="font-size:19px; font-weight:700; letter-spacing:-.3px; color:#241C1B;">Métodos de pago</div>
      </div>
      <div style="background:#fff; border:1px solid rgba(36,28,27,.07); border-radius:26px; padding:20px 22px; box-shadow:0 2px 10px rgba(36,28,27,.045); display:flex; flex-direction:column; gap:16px">
        @php
            $totalRecaudado = collect($metodosPagoData)->sum('total_monto');
            $coloresPago = ['#C8102E', '#E04A65', '#EE8B9D', '#F3AFBB', '#E3DEDB'];
            $gradienteStr = '';
            $acumulado = 0;
            if ($totalRecaudado > 0) {
                foreach($metodosPagoData as $index => $metodo) {
                    $porcentaje = ($metodo->total_monto / $totalRecaudado) * 100;
                    $inicio = $acumulado;
                    $fin = $acumulado + $porcentaje;
                    $color = $coloresPago[$index % count($coloresPago)];
                    $gradienteStr .= "{$color} {$inicio}% {$fin}%, ";
                    $acumulado = $fin;
                }
                $gradienteStr = rtrim($gradienteStr, ', ');
            } else {
                $gradienteStr = '#F1EEED 0% 100%';
            }
        @endphp

        <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap">
          <div style="width:148px; height:148px; flex:none; border-radius:50%; background-image:conic-gradient({{ $gradienteStr }}); display:flex; align-items:center; justify-content:center">
            <div style="width:92px; height:92px; border-radius:50%; background:#fff; display:flex; flex-direction:column; align-items:center; justify-content:center; line-height:1.1">
              <div style="font-size:19px; font-weight:800; letter-spacing:-.7px; font-variant-numeric:tabular-nums; color:#241C1B;">${{ number_format($totalRecaudado, 0, ',', '.') }}</div>
              <div style="font-size:10.5px; font-weight:600; color:#8A7E7C">recaudado</div>
            </div>
          </div>
          <div style="flex:1; min-width:min(170px, 100%); display:flex; flex-direction:column; gap:11px; color:#241C1B;">
            @forelse($metodosPagoData as $index => $metodo)
                @php $porc = $totalRecaudado > 0 ? round(($metodo->total_monto / $totalRecaudado) * 100) : 0; @endphp
                <div style="display:flex; flex-wrap:wrap; align-items:center; gap:10px">
                    <span style="width:11px; height:11px; flex:none; border-radius:4px; background:{{ $coloresPago[$index % count($coloresPago)] }}"></span>
                    <span style="flex:1 1 60px; min-width:0; font-size:14px; font-weight:600">{{ $metodo->nombre }}</span>
                    <span style="font-size:14.5px; font-weight:700; font-variant-numeric:tabular-nums">${{ number_format($metodo->total_monto, 0, ',', '.') }}</span>
                    <span style="font-size:13px; font-weight:700; color:#8A7E7C; font-variant-numeric:tabular-nums; min-width:38px; text-align:right">{{ $porc }}%</span>
                </div>
            @empty
                <div style="font-size:13.5px; font-weight:600; color:#8A7E7C;">Sin pagos registrados.</div>
            @endforelse
          </div>
        </div>
        
        @if(count($metodosPagoData) > 0 && strtolower($metodosPagoData[0]->nombre) === 'efectivo')
            <div style="background:#F6F5F4; border-radius:16px; padding:12px 14px; font-size:13px; font-weight:600; color:#6B6260; display:flex; align-items:center; gap:9px">
                <span class="material-symbols-rounded" style="font-size:19px; color:#C8102E">insights</span>
                El efectivo sigue liderando el recaudo: mantén base suficiente.
            </div>
        @endif
      </div>
    </div>
  </div>

  <div style="display:flex; flex-direction:column; gap:12px; margin-top:20px;">
    <div style="display:flex; align-items:center; gap:11px">
      <span style="width:28px; height:28px; flex:none; border-radius:9px; background:#C8102E; color:#fff; font-size:14px; font-weight:800; display:flex; align-items:center; justify-content:center">4</span>
      <div style="font-size:19px; font-weight:700; letter-spacing:-.3px; color:#241C1B;">Inventario</div>
    </div>
    
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(min(190px, 100%), 1fr)); gap:14px">
      <div style="background:#fff; border:1px solid rgba(36,28,27,.07); border-radius:24px; padding:18px 20px; box-shadow:0 2px 10px rgba(36,28,27,.045); display:flex; flex-direction:column; gap:5px">
        <div style="font-size:12.5px; font-weight:700; color:#8A7E7C">Unidades en stock</div>
        <div style="font-size:34px; font-weight:800; letter-spacing:-1.4px; line-height:1; font-variant-numeric:tabular-nums; color:#241C1B;">{{ number_format($stockTotal, 0, ',', '.') }}</div>
        <div style="font-size:12.5px; font-weight:600; color:#B0A6A4">{{ $productosCatalogo }} productos en catálogo</div>
      </div>
      <div style="background:#fff; border:1px solid rgba(36,28,27,.07); border-radius:24px; padding:18px 20px; box-shadow:0 2px 10px rgba(36,28,27,.045); display:flex; flex-direction:column; gap:5px; border-left:4px solid #C98A12">
        <div style="font-size:12.5px; font-weight:700; color:#8A7E7C">En bajo stock</div>
        <div style="font-size:34px; font-weight:800; letter-spacing:-1.4px; line-height:1; font-variant-numeric:tabular-nums; color:#8A5A06">{{ $bajoStock }}</div>
        <div style="font-size:12.5px; font-weight:600; color:#B0A6A4">Requieren producción pronto</div>
      </div>
      <div style="background:#fff; border:1px solid rgba(36,28,27,.07); border-radius:24px; padding:18px 20px; box-shadow:0 2px 10px rgba(36,28,27,.045); display:flex; flex-direction:column; gap:5px; border-left:4px solid #C8102E">
        <div style="font-size:12.5px; font-weight:700; color:#8A7E7C">Agotados</div>
        <div style="font-size:34px; font-weight:800; letter-spacing:-1.4px; line-height:1; font-variant-numeric:tabular-nums; color:#96001F">{{ $agotados }}</div>
        <div style="font-size:12.5px; font-weight:600; color:#B0A6A4">Sin unidades disponibles</div>
      </div>
      <div style="background:#fff; border:1px solid rgba(36,28,27,.07); border-radius:24px; padding:18px 20px; box-shadow:0 2px 10px rgba(36,28,27,.045); display:flex; flex-direction:column; gap:5px">
        <div style="font-size:12.5px; font-weight:700; color:#8A7E7C">Movimientos del período</div>
        <div style="font-size:34px; font-weight:800; letter-spacing:-1.4px; line-height:1; font-variant-numeric:tabular-nums; color:#241C1B;">{{ $entradas + $salidas }}</div>
        <div style="display:flex; gap:10px; font-size:12.5px; font-weight:700; margin-top:2px">
          <span style="color:#166B3B">↑ {{ $entradas }} entradas</span>
          <span style="color:#96001F">↓ {{ $salidas }} salidas</span>
        </div>
      </div>
    </div>
    
    <div style="background:#fff; border:1px solid rgba(36,28,27,.07); border-radius:24px; padding:18px 22px; box-shadow:0 2px 10px rgba(36,28,27,.045); display:flex; flex-direction:column; gap:12px; margin-bottom: 20px;">
      <div style="font-size:13.5px; font-weight:700; color:#6B6260">Movimientos por motivo</div>
      @php
          $maxMov = count($movimientosPorTipo) > 0 ? collect($movimientosPorTipo)->max('total') : 1;
          $coloresMov = ['#C8102E', '#E04A65', '#EE8B9D', '#F3AFBB', '#F6C3CC'];
          $nombresTipo = [
              'produccion' => 'Producción',
              'salida' => 'Venta',
              'ajuste' => 'Ajuste / Merma',
              'entrada' => 'Entrada externa',
              'anulacion' => 'Anulación (Devolución)'
          ];
      @endphp

      @forelse($movimientosPorTipo as $index => $mov)
      <div style="display:flex; flex-wrap:wrap; align-items:center; gap:12px; color:#241C1B;">
        <span style="width:118px; flex:none; font-size:14px; font-weight:600; text-transform:capitalize;">{{ $nombresTipo[$mov->tipo] ?? $mov->tipo }}</span>
        <span style="flex:1 1 60px; min-width:60px; height:12px; border-radius:6px; background:#F1EEED; overflow:hidden">
            <span style="display:block; height:100%; width:{{ ($mov->total / $maxMov) * 100 }}%; border-radius:6px; background:{{ $coloresMov[$index % 5] }}"></span>
        </span>
        <span style="width:66px; flex:none; text-align:right; font-size:14.5px; font-weight:800; font-variant-numeric:tabular-nums">{{ $mov->total }}</span>
      </div>
      @empty
      <div style="text-align:center; padding: 15px 0; color:#8A7E7C; font-size:13.5px; font-weight:600;">No hay registros de movimientos.</div>
      @endforelse
    </div>
  </div>
</section>