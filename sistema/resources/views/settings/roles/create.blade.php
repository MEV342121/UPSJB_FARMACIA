{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Roles')
@section('name_section', 'Roles')
@section('description', 'Nuevo registro de rol')
@section('item_section', 'Nuevo')
@section('route_section', route('roles.index'))
@section('section', 'Roles')
@section('module', 'Configuraciones')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('roles.store') }}" method="POST"> {{-- POST a store() --}}
            @csrf {{-- token de seguridad; sin él aparece el error 419 --}}
            @include('settings.roles.form') {{-- formulario compartido con edit --}}
        </form>
    </div>
</div>
@endsection
