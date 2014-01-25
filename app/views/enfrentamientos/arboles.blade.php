@extends('layouts.default')

@section('css')
    {{ HTML::style('css/jquery.bracket.min.css') }}
@stop

@section('title')
    Torneo
@stop

@section('description')
    Enfrentamientos del torneo
@stop

@section('breadcrumb')
    <li>
        <a href="{{ Session::get('page.url') }}">
            <i class="fa fa-arrow-circle-left"></i>
            <span>Volver</span>
        </a>
    </li>
@stop

@section('content')
    @if ($errors->any())
    <div id="message" class="error">
        @foreach ($errors->all() as $message)
            {{ $message }} <br>
        @endforeach
    </div>
    @endif

    @if ($torneos->getTotal() == 0)
        <center>Sin resultados.</center>
    @else
        @foreach ($torneos as $e)
            @if ($e->cantidad >= 8)
                <div class="separador">{{ $e->descripcion }}</div>
                <div class="torneo left" data-id="{{$e->codigo}}"></div>
            @endif
        @endforeach

    @endif

@stop

@section('javascript')
    <script>rutaArbol = "{{ URL::action('EnfrentamientosController@getArbol') }}";</script>
    {{ HTML::script('js/jquery.bracket.min.js') }}
    {{ HTML::script('js/ping-pong.arbol.js') }}
@stop
