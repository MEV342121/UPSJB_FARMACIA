{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Proveedores')
@section('name_section', 'Proveedores')
@section('description', 'Editar registro de proveedor')
@section('item_section', 'Editar')
@section('route_section', route('suppliers.index'))
@section('section', 'Proveedores')
@section('module', 'Gestión')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf {{-- token de seguridad --}}
            @method('PUT') {{-- HTML solo envía GET/POST: así Laravel sabe que es update() --}}
            @include('management.suppliers.form') {{-- mismo formulario, ahora con $supplier lleno --}}
        </form>
    </div>
</div>
@endsection
