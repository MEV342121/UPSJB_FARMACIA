@extends('template.administrador')

@section('title', 'Dashboard')
@section('name_section', 'Dashboard')
@section('description', 'Resumen del negocio para tomar decisiones')
@section('item_section', 'Inicio')
@section('route_section', route('dashboard.index'))
@section('section', 'Dashboard')
@section('module', 'Principal')

@section('content')

    {{-- ── 1. Tarjetas de indicadores --}}
    <div class="row g-3 mb-4">
        @php
            $kpis = [
                ['Ventas de hoy', 'S/ ' . number_format($salesToday, 2), 'bi-cash-coin', 'bg-primary-subtle text-primary'],
                ['Ventas del mes', 'S/ ' . number_format($salesMonth, 2), 'bi-calendar3', 'bg-dark-subtle text-dark'],
                ['Clientes', $customers, 'bi-people', 'bg-secondary-subtle text-secondary'],
                ['Medicamentos con stock bajo', $lowStock, 'bi-exclamation-triangle', 'bg-warning-subtle text-warning'],
            ];
        @endphp
        @foreach ($kpis as [$label, $value, $icon, $color])
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-white border-0 shadow-sm h-100 p-3 d-flex flex-row align-items-center gap-3">
                    <div class="kpi-icon {{ $color }}"><i class="bi {{ $icon }}"></i></div>
                    <div>
                        <small class="text-secondary">{{ $label }}</small>
                        <div class="fs-5 fw-bold">{{ $value }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── 2. Gráficos: cada <canvas> es un lienzo donde Chart.js dibuja --}}
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary h-100 p-3">
                <h2 class="h6 fw-bold">Ventas de los últimos 7 días (S/)</h2>
                <canvas id="chartDays" height="120"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary h-100 p-3">
                <h2 class="h6 fw-bold">Ventas del mes por categoría</h2>
                <canvas id="chartCategories"></canvas>
            </div>
        </div>
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary p-3">
                <h2 class="h6 fw-bold">Los 5 medicamentos más vendidos del mes (unidades)</h2>
                {{-- Un contenedor con altura fija evita que el gráfico se aplaste --}}
                <div style="height:260px"><canvas id="chartTop"></canvas></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Chart.js guardado en public/js: funciona sin internet --}}
    <script src="{{ asset('js/chart.umd.min.js') }}"></script>
    {{-- @json convierte los datos de PHP en datos de JavaScript --}}
    <script>
        const days = @json($days);
        const totals = @json($totals);
        const byCategory = @json($byCategory);
        const topMedicines = @json($topMedicines);

        const PRIMARY = '#ff0a41', DARK = '#323232', GRAY = '#4b5563'; // colores de bootstrap.css del proyecto

        // Gráfico de líneas: ventas por día
        new Chart(document.getElementById('chartDays'), {
            type: 'line',
            data: { labels: days,
                    datasets: [{ label: 'Ventas (S/)', data: totals, borderColor: PRIMARY,
                                 backgroundColor: 'rgba(255,10,65,.12)', fill: true, tension: .3 }] },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });

        // Gráfico de dona: ventas por categoría
        new Chart(document.getElementById('chartCategories'), {
            type: 'doughnut',
            data: { labels: byCategory.map(c => c.name),
                    datasets: [{ data: byCategory.map(c => c.total),
                                 backgroundColor: [PRIMARY, DARK, GRAY, '#ff8aa5', '#9ca3af', '#ffd0db'] }] },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Gráfico de barras horizontales: los 5 más vendidos
        new Chart(document.getElementById('chartTop'), {
            type: 'bar',
            data: { labels: topMedicines.map(m => m.name),
                    datasets: [{ label: 'Unidades', data: topMedicines.map(m => m.units), backgroundColor: DARK }] },
            options: { indexAxis: 'y', maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    </script>
@endpush
