@extends('layouts.app')

@section('hero')
    <div class="hero-categorias">
        <form class="container h-100" action="{{route('buscar.show')}}">
            <div class="row h-100 align-items-center">
                <div class="col-md-4 texto-buscar">
                    <p class="display-4">Encuentra una receta para tu próxima comida</p>
                    <input type="search"
                            name="buscar"
                            class="form-control"
                            placeholder="Buscar Receta"
                    />
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-0 mb-4">
            Resultados Búsqueda por: {{$busqueda}}
        </h2>
        <div class="row">
            @foreach($recetas as $receta)
                @include('ui.receta')
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{$recetas->links()}}
        </div>
    </div>
@endsection