@extends('layouts.default')

@section('title')
	Torneos
@stop

@section('description')
	Aquí se listan todos los torneos registrados. Puedes crear nuevos, editar y borrar existentes.
@stop

@section('breadcrumb')
    <li>
        <form action="{{ URL::action('TorneosController@getBuscar') }}" method="get">
            <i class="fa fa-search"></i>
            <input name="q" class="busqueda" type="text" placeholder="Búsqueda">
        </form>

    </li>
	@if (Request::segment(2) == 'buscar')
		<li>
			<a href="{{ URL::action('TorneosController@getIndex') }}">
				<i class="fa fa-arrow-circle-left"></i>
				<span>Volver</span>
			</a>
		</li>
	@endif
    <li>
        <a href="{{ URL::action('TorneosController@getAgregar') }}">
            <i class="fa fa-plus"></i><span>Nuevo torneo</span></a>
    </li>
@stop


@section('content')
	@if (Request::segment(2) == 'buscar')
		Mostrando resultados de búsqueda para: <b>{{ $q }}</b><br><br>
	@endif
	@if ($torneos->getTotal() == 0)
		<center>Sin resultados.</center>
	@else
		<table class="tabla">
			<tbody>
			    <tr>
			        <th>Descripción</th>
			        <th>Fecha de inicio</th>
			        <th>Fecha de fin</th>
                    <th>Tipo</th>
                    <th>Cantidad de participantes</th>
                    <th>Acción</th>
			    </tr>
			    @foreach ($torneos as $e)
			    <tr>
			        <td>
			            <a href="javascript:void('modificarEsto');">{{ $e->descripcion }}</a>
			        </td>
			        <td>{{ $e->fecha_inicio }}</td>
			        <td>{{ $e->fecha_fin }}</td>
			        <td>{{ $e->tipo}}</td>
			        <td>{{ $e->cantidad }}</td>
			        <td>
			            <a class="borrar" href="{{ URL::action('TorneosController@getEliminar', array($e->codigo)) }}" data-msg="{{ $e->descripcion }}">
			                <i class="fa fa-times"></i>Borrar</a>
			        </td>
			    </tr>
			    @endforeach
			</tbody>
		</table>
	@endif
	@if (Request::segment(2) == 'buscar')
		{{ $torneos->appends(array('q' => $q ))->links() }}
	@else
		{{ $torneos->links() }}
	@endif
@stop