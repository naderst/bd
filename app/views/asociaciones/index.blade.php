@extends('layouts.default')

@section('title')
	Asociaciones
@stop

@section('description')
	Aquí se listan todas las asociaciones registradas. Puedes crear nuevas, editar y borrar existentes.
@stop

@section('breadcrumb')
    <li>
        <form action="" method="post">
            <i class="fa fa-search"></i>
            <input class="busqueda" type="text" placeholder="Búsqueda">
        </form>

    </li>
    <li>
        <a href="{{ URL::action('AsociacionesController@getAgregar') }}">
            <i class="fa fa-plus"></i>Nueva asociación</a>
    </li>
@stop

@section('content')
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
		            <a class="borrar" href="{{ URL::action('AsociacionesController@getEliminar', array($e->codigo)) }}" onclick="javascript:return borrarItem('{{ $e->nombre }}');">
		                <i class="fa fa-times"></i>Borrar</a>
		        </td>
		    </tr>
		    @endforeach
		</tbody>
	</table>
	{{ $asociaciones->links() }}
@stop