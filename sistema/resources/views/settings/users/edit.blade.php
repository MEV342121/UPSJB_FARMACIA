{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Usuarios')
@section('name_section', 'Usuarios')
@section('description', 'Editar registro de usuario')
@section('item_section', 'Editar')
@section('route_section', route('users.index'))
@section('section', 'Usuarios')
@section('module', 'Configuraciones')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf {{-- token de seguridad --}}
            @method('PUT') {{-- HTML solo envía GET/POST: así Laravel sabe que es update() --}}
            @include('settings.users.form') {{-- mismo formulario, ahora con $user lleno --}}
        </form>
    </div>
</div>
@endsection
