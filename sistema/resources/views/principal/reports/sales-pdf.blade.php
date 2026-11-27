<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte de ventas</title>
  {{-- DOMPDF no carga bootstrap: todo el estilo va aquí, en línea --}}
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; }
    h1 { font-size: 16px; margin: 0; color: #ff0a41; }
    .sub { color: #666; margin: 2px 0 10px; }
    .filters { margin-bottom: 8px; }
    .filters span { margin-right: 14px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #323232; color: #fff; text-align: left; padding: 5px; font-size: 9px; text-transform: uppercase; }
    td { padding: 4px 5px; border-bottom: 1px solid #ddd; }
    .r { text-align: right; }
    .summary td { border: 0; padding: 6px 10px 6px 0; }
    .summary strong { font-size: 13px; }
    tfoot th { background: #eee; color: #000; }
    .foot { margin-top: 14px; color: #888; font-size: 8px; }
  </style>
</head>
<body>
  <h1>FARM SJB · Reporte de ventas</h1>
  <div class="sub">Del {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}</div>

  <div class="filters">
    @foreach ($filters as $label => $value)
      <span><strong>{{ $label }}:</strong> {{ $value }}</span>
    @endforeach
  </div>

  <table class="summary">
    <tr>
      <td>N.° de ventas<br><strong>{{ $summary['count'] }}</strong></td>
      <td>Total vendido<br><strong>S/ {{ number_format($summary['total'], 2) }}</strong></td>
      <td>IGV<br><strong>S/ {{ number_format($summary['igv'], 2) }}</strong></td>
      <td>Venta promedio<br><strong>S/ {{ number_format($summary['average'], 2) }}</strong></td>
    </tr>
  </table>

  <table>
    <thead>
      <tr><th>N.°</th><th>Fecha</th><th>Cliente</th><th>Vendedor</th><th class="r">IGV</th><th class="r">Total</th></tr>
    </thead>
    <tbody>
      @forelse ($sales as $sale)
        <tr>
          <td>{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</td>
          <td>{{ $sale->date->format('d/m/Y H:i') }}</td>
          <td>{{ $sale->customer->name }}</td>
          <td>{{ $sale->user->name }}</td>
          <td class="r">S/ {{ number_format($sale->igv, 2) }}</td>
          <td class="r">S/ {{ number_format($sale->total, 2) }}</td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center">No hay ventas con esos filtros.</td></tr>
      @endforelse
    </tbody>
    @if ($sales->isNotEmpty())
      <tfoot>
        <tr><th colspan="4" class="r">Totales</th>
            <th class="r">S/ {{ number_format($summary['igv'], 2) }}</th>
            <th class="r">S/ {{ number_format($summary['total'], 2) }}</th></tr>
      </tfoot>
    @endif
  </table>

  <div class="foot">Generado el {{ now()->format('d/m/Y H:i') }} por {{ auth()->user()->name }}</div>
</body>
</html>
