@extends('template.administrador')

@section('title', 'Reporte de ventas')
@section('name_section', 'Reporte de ventas')
@section('description', 'Ventas por rango de fechas y filtros')
@section('item_section', 'Inicio')
@section('route_section', route('reports.sales'))
@section('section', 'Reportes')
@section('module', 'Principal')

@section('content')

    {{-- ── 1. Filtros: formulario GET, así el reporte se puede volver a abrir con la misma URL --}}
    <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary p-3 mb-3">
        <form method="GET" action="{{ route('reports.sales') }}" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label for="from" class="form-label small">Desde</label>
                <input type="date" name="from" id="from" value="{{ $from }}" class="form-control @error('from') is-invalid @enderror">
            </div>
            <div class="col-md-2">
                <label for="to" class="form-label small">Hasta</label>
                <input type="date" name="to" id="to" value="{{ $to }}" class="form-control @error('to') is-invalid @enderror">
            </div>
            <div class="col-md-2">
                <label for="customer_id" class="form-label small">Cliente</label>
                <select name="customer_id" id="customer_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(request('customer_id') == $customer->id)>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="user_id" class="form-label small">Vendedor</label>
                <select name="user_id" id="user_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="category_id" class="form-label small">Categoría</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Todas</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary text-white flex-grow-1"><i class="bi bi-funnel"></i> Filtrar</button>
                <a href="{{ route('reports.sales') }}" class="btn btn-light" title="Quitar filtros"><i class="bi bi-x-lg"></i></a>
            </div>
            @error('to') <div class="col-12 text-danger small">{{ $message }}</div> @enderror
        </form>
    </div>

    {{-- ── Exportar: llevan los mismos filtros en la dirección --}}
    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="{{ route('reports.sales.excel', request()->query()) }}" class="btn btn-sm btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> Exportar Excel
        </a>
        <a href="{{ route('reports.sales.pdf', request()->query()) }}" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
        </a>
    </div>

    {{-- ── 2. Resumen --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-lg-3"><div class="card bg-white border-0 shadow-sm p-3"><small class="text-secondary">N.° de ventas</small><div class="fs-5 fw-bold">{{ $summary['count'] }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="card bg-white border-0 shadow-sm p-3"><small class="text-secondary">Total vendido</small><div class="fs-5 fw-bold">S/ {{ number_format($summary['total'], 2) }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="card bg-white border-0 shadow-sm p-3"><small class="text-secondary">IGV</small><div class="fs-5 fw-bold">S/ {{ number_format($summary['igv'], 2) }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="card bg-white border-0 shadow-sm p-3"><small class="text-secondary">Venta promedio</small><div class="fs-5 fw-bold">S/ {{ number_format($summary['average'], 2) }}</div></div></div>
    </div>

    {{-- ── 3. Gráfico del rango --}}
    <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary p-3 mb-3">
        <h2 class="h6 fw-bold">Total vendido por día (S/)</h2>
        <canvas id="chartReport" height="90"></canvas>
    </div>

    {{-- ── 4. Detalle --}}
    <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary p-3">
        <div class="table-responsive">
            <table class="table table-sm table-hover w-100 bg-white mb-0">
                <thead>
                    <tr class="text-uppercase small">
                        <th>N.°</th><th>Fecha</th><th>Cliente</th><th>Vendedor</th>
                        <th class="text-end">IGV</th><th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td><a href="{{ route('sales.show', $sale) }}">{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</a></td>
                            <td>{{ $sale->date->format('d/m/Y H:i') }}</td>
                            <td>{{ $sale->customer->name }}</td>
                            <td>{{ $sale->user->name }}</td>
                            <td class="text-end">S/ {{ number_format($sale->igv, 2) }}</td>
                            <td class="text-end">S/ {{ number_format($sale->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-secondary">No hay ventas con esos filtros.</td></tr>
                    @endforelse
                </tbody>
                @if ($sales->isNotEmpty())
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Totales</th>
                            <th class="text-end">S/ {{ number_format($summary['igv'], 2) }}</th>
                            <th class="text-end">S/ {{ number_format($summary['total'], 2) }}</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/chart.umd.min.js') }}"></script>
    <script>
        // $chart es una colección ['24/11' => 85.5, ...]: keys() son los días y values() los montos
        const labels = @json($chart->keys());
        const values = @json($chart->values());

        new Chart(document.getElementById('chartReport'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Total (S/)', data: values, backgroundColor: '#ff0a41' }] },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
    </script>
@endpush
