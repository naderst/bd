@extends('layouts.default')

@section('title')
	Asociaciones
@stop

@section('description')
	Aquí se listan todas las asociaciones registradas. Puedes crear nuevas, editar y borrar existentes.
@stop

@section('breadcrumb')
    <li>
        <form action="{{ URL::action('AsociacionesController@getBuscar') }}" method="get">
            <i class="fa fa-search"></i>
            <input name="q" class="busqueda" type="text" placeholder="Búsqueda">
        </form>

    </li>
	@if (Request::segment(2) == 'buscar')
		<li>
			<a href="{{ URL::action('AsociacionesController@getIndex') }}">
				<i class="fa fa-arrow-circle-left"></i>
				<span>Volver</span>
			</a>
		</li>
	@endif
    <li>
        <a href="{{ URL::action('AsociacionesController@getAgregar') }}">
            <i class="fa fa-plus"></i><span>Nueva asociación</span></a>
    </li>
@stop

@section('content')
	@if (Request::segment(2) == 'buscar')
		Mostrando resultados de búsqueda para: <b>{{ $q }}</b><br><br>
	@endif
	@if ($asociaciones->getTotal() == 0)
		<center>Sin resultados.</center>
	@else
		<table class="tabla">
			<tbody>
			    <tr>
			        <th>Nombre</th>
			        <th>Estado</th>
			        <th>Acción</th>
			    </tr>
			    @foreach ($asociaciones as $e)
			    <tr>
			        <td>
			            <a href="{{ URL::action('AsociacionesController@getModificar', array($e->codigo)) }}">{{ $e->nombre }}</a>
			        </td>
			        <td>{{ $e->estado }}</td>
			        <td>
			            <a class="borrar" href="{{ URL::action('AsociacionesController@getEliminar', array($e->codigo)) }}" data-msg="{{ $e->nombre }}">
			                <i class="fa fa-times"></i>Borrar</a>
			        </td>
			    </tr>
			    @endforeach
			</tbody>
		</table>
	@endif
	@if (Request::segment(2) == 'buscar')
		{{ $asociaciones->appends(array('q' => $q ))->links() }}
	@else
		{{ $asociaciones->links() }}
	@endif
@stop