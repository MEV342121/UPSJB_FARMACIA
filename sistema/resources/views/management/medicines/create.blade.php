{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Medicamentos')
@section('name_section', 'Medicamentos')
@section('description', 'Nuevo registro de medicamento')
@section('item_section', 'Nuevo')
@section('route_section', route('medicines.index'))
@section('section', 'Medicamentos')
@section('module', 'Gestión')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data"> {{-- POST a store() --}}
            @csrf {{-- token de seguridad; sin él aparece el error 419 --}}
            @include('management.medicines.form') {{-- formulario compartido con edit --}}
        </form>
    </div>
</div>
@endsection
