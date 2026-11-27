@extends('template.administrador')

@section('title', 'MEDICINES')
@section('name_section', 'MEDICAMENTOS')
@section('description', 'Listado de medicamentos')
@section('item_section', 'Inicio')
@section('section', 'Medicamentos')
@section('module', 'Gestión')

@section('content')
@if (session('ok'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('ok') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-12 col-md-3">
                <a href="{{ route('medicines.create') }}" class="btn btn-primary rounded-3 text-uppercase text-white w-100">
                    <i class="bi bi-plus-lg me-2"></i><span class="small fw-medium">Nuevo registro</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <h6 class="text-uppercase small text-muted mb-3">Total de registros encontrados: {{ $medicines->count() }}</h6>
        <table id="display" class="table table-sm table-hover w-100 bg-white">
            <thead>
                <tr>
                    <th class="text-center align-middle text-uppercase small">Nº</th>
                    <th class="text-center align-middle text-uppercase small">Categoría</th>
                    <th class="text-center align-middle text-uppercase small">Nombre</th>
                    <th class="text-center align-middle text-uppercase small">Precio</th>
                    <th class="text-center align-middle text-uppercase small">Stock</th>
                    <th class="text-center align-middle text-uppercase small">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $contador = 1;
                @endphp
                @foreach ($medicines as $medicine)
                    <tr>
                        <td class="text-center align-middle">{{ $contador }}</td>
                        <td class="text-start align-middle">{{ $medicine->categoria->nombre ?? $medicine->categoria->name ?? '-' }}</td>
                        <td class="text-start align-middle">{{ $medicine->nombre }}</td>
                        <td class="text-end align-middle">{{ number_format((float) $medicine->precio, 2) }}</td>
                        <td class="text-center align-middle">{{ $medicine->stock }}</td>
                        <td class="text-center align-middle">
                            <div class="dropdown">
                                <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('medicines.edit', $medicine->id) }}">Editar</a></li>
                                    <li>
                                        <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST"
                                            onsubmit="return confirm('¿Estas seguro de eliminar este registro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">Eliminar</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @php
                        $contador++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection