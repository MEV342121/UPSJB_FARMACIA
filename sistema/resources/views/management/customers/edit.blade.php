{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Clientes')
@section('name_section', 'Clientes')
@section('description', 'Editar registro de cliente')
@section('item_section', 'Editar')
@section('route_section', route('customers.index'))
@section('section', 'Clientes')
@section('module', 'Gestión')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf {{-- token de seguridad --}}
            @method('PUT') {{-- HTML solo envía GET/POST: así Laravel sabe que es update() --}}
            @include('management.customers.form') {{-- mismo formulario, ahora con $customer lleno --}}
        </form>
    </div>
</div>
@endsection
