{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Clientes')
@section('name_section', 'Clientes')
@section('description', 'Nuevo registro de cliente')
@section('item_section', 'Nuevo')
@section('route_section', route('customers.index'))
@section('section', 'Clientes')
@section('module', 'Gestión')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('customers.store') }}" method="POST"> {{-- POST a store() --}}
            @csrf {{-- token de seguridad; sin él aparece el error 419 --}}
            @include('management.customers.form') {{-- formulario compartido con edit --}}
        </form>
    </div>
</div>
@endsection
