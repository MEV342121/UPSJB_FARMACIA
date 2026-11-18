@extends("template.administrador")

@section('title','ROLES')
@section('name_section','ROLES')
@section('description','Nuevo Rol')
@section('item_section','Nuevo Registro')
@section('section','ROLES')
@section('module','Configuraciones')

@section('content')
 <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
        <div class="card-body">
            <form action="{{route('roles.store')}}" method="POST">
                @csrf
                @include('settings.roles.form')

            </form>
                    
  </div>
</div>


@endsection