@extends("template.administrador")

@section('title','CATEGORIES')
@section('name_section','CATEGORIAS')
@section('description','Nueva categoria')
@section('item_section','Nuevo Registro')
@section('section','Categorias')
@section('module','Configuraciones')

@section('content')
 <div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
        <div class="card-body">
            <form action="{{route('categories.store')}}" method="POST">
                @csrf
                @include('settings.categories.form')

            </form>
                    
  </div>
</div>


@endsection