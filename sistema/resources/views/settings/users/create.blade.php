{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Usuarios')
@section('name_section', 'Usuarios')
@section('description', 'Nuevo registro de usuario')
@section('item_section', 'Nuevo')
@section('route_section', route('users.index'))
@section('section', 'Usuarios')
@section('module', 'Configuraciones')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST"> {{-- POST a store() --}}
            @csrf {{-- token de seguridad; sin él aparece el error 419 --}}
            @include('settings.users.form') {{-- formulario compartido con edit --}}
        </form>
    </div>
</div>
@endsection
