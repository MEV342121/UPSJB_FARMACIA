{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Ventas')
@section('name_section', 'Ventas')
@section('description', 'Listado de ventas registradas')
@section('item_section', 'Inicio')
@section('route_section', route('sales.index'))
@section('section', 'Ventas')
@section('module', 'Gestión')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-12 col-md-3">
                <a href="{{ route('sales.create') }}" class="btn btn-primary rounded-3 text-uppercase text-white w-100">
                    <i class="bi bi-plus-lg me-2"></i><span class="small fw-medium">Nueva venta</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- Mensajes flash: ok (verde) y error (rojo) --}}
        @include('partials.alerts')

        <h6 class="text-uppercase small text-muted mb-3">Total de registros encontrados: {{ $sales->count() }}</h6>
        <table id="display" class="table table-sm table-hover w-100 bg-white">
            <thead>
                <tr>
                    <th class="text-center align-middle text-uppercase small">Nº</th>
                    <th class="text-center align-middle text-uppercase small">Fecha</th>
                    <th class="text-center align-middle text-uppercase small">Cliente</th>
                    <th class="text-center align-middle text-uppercase small">Vendedor</th>
                    <th class="text-center align-middle text-uppercase small">Total</th>
                    <th class="text-center align-middle text-uppercase small">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- @forelse recorre la colección; si está vacía muestra el bloque @empty --}}
                @forelse ($sales as $sale)
                <tr>
                    <td class="text-center align-middle">{{ $loop->iteration }} {{-- 1, 2, 3... --}}</td>
                    <td class="text-center align-middle">{{ $sale->date->format('d/m/Y H:i') }}</td>
                    <td class="text-start align-middle">{{ $sale->customer->name }}</td>
                    <td class="text-start align-middle">{{ $sale->user->name }}</td>
                    <td class="text-end align-middle">S/ {{ number_format($sale->total, 2) }}</td>
                    <td class="text-center align-middle">
                        <div class="dropdown">
                            <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('sales.show', $sale) }}">Ver detalle</a></li>
                                {{-- Solo el administrador ve la opción Anular --}}
                                @if (auth()->user()->hasRole('Administrador'))
                                <li>
                                    <form action="{{ route('sales.destroy', $sale) }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que desea anular esta venta? El stock será devuelto.')">
                                        @csrf
                                        @method('DELETE') {{-- verbo real: destroy() --}}
                                        <button type="submit" class="dropdown-item text-danger">Anular</button>
                                    </form>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">No hay ventas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
