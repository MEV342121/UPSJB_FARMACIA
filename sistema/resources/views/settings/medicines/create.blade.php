@extends("template.administrador")

@section('title', 'MEDICINES')
@section('name_section', 'MEDICAMENTOS')
@section('description', 'Nuevo medicamento')
@section('item_section', 'Nuevo Registro')
@section('section', 'Medicamentos')
@section('module', 'Gestión')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('medicines.store') }}" method="POST">
            @csrf
            @include('managament.medicines.form')
        </form>
    </div>
</div>
@endsection