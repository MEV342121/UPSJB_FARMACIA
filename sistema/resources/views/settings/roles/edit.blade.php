{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Roles')
@section('name_section', 'Roles')
@section('description', 'Editar registro de rol')
@section('item_section', 'Editar')
@section('route_section', route('roles.index'))
@section('section', 'Roles')
@section('module', 'Configuraciones')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf {{-- token de seguridad --}}
            @method('PUT') {{-- HTML solo envía GET/POST: así Laravel sabe que es update() --}}
            @include('settings.roles.form') {{-- mismo formulario, ahora con $role lleno --}}
        </form>
    </div>
</div>
@endsection
