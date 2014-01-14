@extends('layouts.default')

@section('title')
	Clubes
@stop

@section('description')
	Aquí se listan todos los clubes registrados. Puedes crear nuevos, editar y borrar existentes.
@stop

@section('breadcrumb')
    <li>
        <form action="{{ URL::action('ClubesController@getBuscar') }}" method="get">
            <i class="fa fa-search"></i>
            <input name="q" class="busqueda" type="text" placeholder="Búsqueda">
        </form>

    </li>
	@if (Request::segment(2) == 'buscar')
		<li>
			<a href="{{ URL::action('ClubesController@getIndex') }}">
				<i class="fa fa-arrow-circle-left"></i>
				<span>Volver</span>
			</a>
		</li>
	@endif
    <li>
        <a href="{{ URL::action('ClubesController@getAgregar') }}">
            <i class="fa fa-plus"></i>Nuevo club</a>
    </li>
@stop

@section('content')
	@if (Request::segment(2) == 'buscar')
		Mostrando resultados de búsqueda para: <b>{{ $q }}</b><br><br>
	@endif
	@if ($clubes->getTotal() == 0)
		<center>Sin resultados.</center>
	@else
		<table class="tabla">
			<tbody>
		    	<tr>
		    		<th>Nombre</th>
		    		<th>Asociación</th>
		    		<th>Acción</th>
		    	</tr>
			    @foreach ($clubes as $e)
			    <tr>
			    	<td><a href="{{ URL::action('ClubesController@getModificar', array($e->codigo)) }}">{{ $e->nombre }}</a></td>
			    	<td>{{ $e->asociacion->nombre }}</td>
			    	<td>
			            <a class="borrar" href="{{ URL::action('ClubesController@getEliminar', array($e->codigo)) }}" data-msg="{{ $e->nombre }}">
			                <i class="fa fa-times"></i>Borrar</a>
			    	</td>
			    </tr>
				@endforeach
			</tbody>
		</table>
	@endif
	@if (Request::segment(2) == 'buscar')
		{{ $clubes->appends(array('q' => $q ))->links() }}
	@else
		{{ $clubes->links() }}
	@endif
@stop