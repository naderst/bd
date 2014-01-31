@extends('layouts.default')

@section('title')
    Ranking
@stop

@section('description')
    Aquí se listan todos los ranking de los atletas registrados.
@stop

@section('breadcrumb')
    <li>
        <form action="{{ URL::action('RankingController@getBuscar') }}" method="get">
            <i class="fa fa-search"></i>
            <input name="q" class="busqueda" type="text" placeholder="Búsqueda">
        </form>

    </li>
    @if (Request::segment(2) == 'buscar')
        <li>
            <a href="{{ URL::action('RankingController@getIndex') }}">
                <i class="fa fa-arrow-circle-left"></i>
                <span>Volver</span>
            </a>
        </li>
    @endif
@stop

@section('content')
    @if (Request::segment(2) == 'buscar')
        Mostrando resultados de búsqueda para: <b>{{ $q }}</b><br><br>
    @endif

    <div class="separador">Ranking Estadal</div>

    @if ($ranking_estadal->getTotal() == 0)
        <center>Sin resultados.</center>
    @else
        <table class="tabla">
            <tbody>
                <tr>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Partidos jugados</th>
                    <th>Partidos ganados</th>
                    <th>Partidos perdidos</th>
                    <th>Puntos</th>
                </tr>
                @foreach ($ranking_estadal as $e)
                <tr>
                    <td>{{ $e->cedula_atleta }}</td>
                    <td>{{ $e->nombres.' '.$e->apellidos }} </td>
                    <td>{{ $e->estado }} </td>
                    <td>{{ $e->partidos_jugados }}</td>
                    <td>{{ $e->partidos_ganados }}</td>
                    <td>{{ $e->partidos_perdidos }}</td>
                    <td>{{ $e->puntos }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="separador">Ranking Nacional</div>

    @if ($ranking_nacional->getTotal() == 0)
        <center>Sin resultados.</center>
    @else
        <table class="tabla">
            <tbody>
                <tr>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Partidos jugados</th>
                    <th>Partidos ganados</th>
                    <th>Partidos perdidos</th>
                    <th>Puntos</th>
                </tr>
                @foreach ($ranking_nacional as $e)
                <tr>
                    <td>{{ $e->cedula_atleta }}</td>
                    <td>{{ $e->nombres.' '.$e->apellidos }} </td>
                    <td>{{ $e->partidos_jugados }}</td>
                    <td>{{ $e->partidos_ganados }}</td>
                    <td>{{ $e->partidos_perdidos }}</td>
                    <td>{{ $e->puntos }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if (Request::segment(2) == 'buscar')
        {{ $ranking_estadal->appends(array('q' => $q ))->links() }}
    @else
        {{ $ranking_estadal->links() }}
    @endif
@stop
