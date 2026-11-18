@extends("template.administrador")

@section('title','ROLES')
@section('name_section','ROLES')
@section('description','Actualizar rol')
@section('item_section','Actualizar Registro')
@section('section','Roles')
@section('module','Configuraciones')

@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('settings.roles.form')
        </form>
    </div>
</div>
@endsection