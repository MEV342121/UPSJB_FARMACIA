{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Medicamentos')
@section('name_section', 'Medicamentos')
@section('description', 'Listado de registros de medicamentos')
@section('item_section', 'Inicio')
@section('route_section', route('medicines.index'))
@section('section', 'Medicamentos')
@section('module', 'Gestión')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-12 col-md-3 mb-2 mb-md-0">
                <a href="{{ route('medicines.create') }}" class="btn btn-primary rounded-3 text-uppercase text-white w-100">
                    <i class="bi bi-plus-lg me-2"></i><span class="small fw-medium">Nuevo registro</span>
                </a>
            </div>

            {{-- Filtros: el formulario usa GET, así los filtros viajan en la URL (?search=...&category_id=...) --}}
            <div class="col-12 col-md-9">
                <form action="{{ route('medicines.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-12 col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="category_id" class="form-select">
                            <option value="">Todas las categorías</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="form-check">
                            <input type="checkbox" name="low_stock" value="1" id="low_stock" class="form-check-input"
                                @checked(request('low_stock'))>
                            <label for="low_stock" class="form-check-label small">Stock bajo</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 d-flex gap-1">
                        <button type="submit" class="btn btn-outline-primary w-100" title="Filtrar"><i class="bi bi-search"></i></button>
                        <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary w-100" title="Limpiar filtros"><i class="bi bi-x-lg"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- Mensajes flash: ok (verde) y error (rojo) --}}
        @include('partials.alerts')

        <h6 class="text-uppercase small text-muted mb-3">Total de registros encontrados: {{ $medicines->count() }}</h6>
        <table id="display" class="table table-sm table-hover w-100 bg-white">
            <thead>
                <tr>
                    <th class="text-center align-middle text-uppercase small">Nº</th>
                    <th class="text-center align-middle text-uppercase small">Imagen</th>
                    <th class="text-center align-middle text-uppercase small">Nombre</th>
                    <th class="text-center align-middle text-uppercase small">Categoría</th>
                    <th class="text-center align-middle text-uppercase small">Precio</th>
                    <th class="text-center align-middle text-uppercase small">Stock</th>
                    <th class="text-center align-middle text-uppercase small">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- @forelse recorre la colección; si está vacía muestra el bloque @empty --}}
                @forelse ($medicines as $medicine)
                <tr>
                    <td class="text-center align-middle">{{ $loop->iteration }} {{-- 1, 2, 3... --}}</td>
                    <td class="text-center align-middle">
                        @if ($medicine->image)
                            <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}"
                                class="rounded" style="width: 48px; height: 48px; object-fit: cover">
                        @else
                            <i class="bi bi-image text-muted fs-4"></i>
                        @endif
                    </td>
                    <td class="text-start align-middle">{{ $medicine->name }}</td>
                    {{-- Gracias a with('category') esto no hace una consulta por fila --}}
                    <td class="text-center align-middle">{{ $medicine->category->name }}</td>
                    <td class="text-end align-middle">S/ {{ number_format($medicine->price, 2) }}</td>
                    <td class="text-center align-middle">
                        {{-- En rojo si el stock está bajo --}}
                        <span class="badge {{ $medicine->stock <= $lowStock ? 'bg-danger' : 'bg-success' }}">{{ $medicine->stock }}</span>
                    </td>
                    <td class="text-center align-middle">
                        <div class="dropdown">
                            <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('medicines.edit', $medicine) }}">Editar</a></li>
                                <li>
                                    <form action="{{ route('medicines.destroy', $medicine) }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que desea eliminar este medicamento?')">
                                        @csrf
                                        @method('DELETE') {{-- verbo real: destroy() --}}
                                        <button type="submit" class="dropdown-item text-danger">Eliminar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">No se encontraron medicamentos</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
