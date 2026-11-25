{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Proveedores')
@section('name_section', 'Proveedores')
@section('description', 'Nuevo registro de proveedor')
@section('item_section', 'Nuevo')
@section('route_section', route('suppliers.index'))
@section('section', 'Proveedores')
@section('module', 'Gestión')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('suppliers.store') }}" method="POST"> {{-- POST a store() --}}
            @csrf {{-- token de seguridad; sin él aparece el error 419 --}}
            @include('management.suppliers.form') {{-- formulario compartido con edit --}}
        </form>
    </div>
</div>
@endsection
