@extends('template.administrador')

@section('title', 'CATEGORIES')
@section('name_section', 'CATEGORIAS')
@section('description', 'Listado de categorias')
@section('item_section', 'Inicio')
@section('section', 'Categorias')
@section('module', 'Configuraciones')

@section('content')
    <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col-12 col-md-3">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-3 text-uppercase text-white w-100">
                        <i class="bi bi-plus-lg me-2"></i><span class="small fw-medium">Nuevo registro</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h6 class="text-uppercase small text-muted mb-3">Total de registros encontrados: {{ $categories->count() }}</h6>
            <table id="display" class="table table-sm table-hover w-100 bg-white">
                <thead>
                    <tr>
                        <th class="text-center align-middle text-uppercase small">Nº</th>
                        <th class="text-center align-middle text-uppercase small">Nombre</th>
                        <th class="text-center align-middle text-uppercase small">Descripción</th>
                        <th class="text-center align-middle text-uppercase small">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                          $contador=1;
                    @endphp
                    @foreach ($categories as $category)
                        <tr>
                            <td class="text-center align-middle">{{ $contador }}</td>
                            <td class="text-start align-middle">{{ $category->name }}</td>
                            <td class="text-start align-middle">{{ $category->description }}</td>
                            <td class="text-center align-middle">
                                <div class="dropdown">
                                    <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('categories.edit', $category) }}">Editar</a></li>
                                        <li>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection