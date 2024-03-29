@extends('layouts.app')

@section('botones')

@endsection

@section('content')
    <article class="contenido-receta bg-white p-5 shadow">
        <h1 class="text-center mb-4">{{$receta->titulo}}</h1>
        <div class="imagen-receta">
            <img src="/storage/{{$receta->imagen}}" class="w-100"/>
        </div>
        <div class="receta-meta">
            <p>
                <span class="font-weight-bold text-primary">Escrito en: </span>
                {{$receta->categoria->nombre}}
            </p>
            <p>
                <span class="font-weight-bold text-primary">Autor: </span>
                {{$receta->autor->name}}
            </p>
            <p>
                <span class="font-weight-bold text-primary">Fecha: </span>
                @php
                    $fecha = $receta->created_at
                @endphp
                <fecha-receta fecha="{{$fecha}}"></fecha-receta>
            </p>
            <div class="ingredientes">
                <h2 class="my-3 text-primary">Ingredientes: </h2>
                {!!$receta->ingredientes!!}
            </div>
            <div class="preparacion">
                <h2 class="my-3 text-primary">Preparación: </h2>
                {!!$receta->preparacion!!}
            </div>

            <div class="justify-content-center row text-center">
                <like-button 
                    receta-id="{{$receta->id}}"
                    like="{{$like}}"
                    likes="{{$likes}}"
                  >
                </like-button>
      
            </div>
        </div>
    </article>
@endsection