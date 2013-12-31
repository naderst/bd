@extends('layouts.default')

@section('content')
	<table cellspacing="0" cellpadding="5" border="1">
    	<tr>
    		<th>Nombre</th>
    		<th>Estado</th>
    		<th>Acción</th>
    	</tr>
	    @foreach ($asociaciones as $e)
	    <tr>
	    	<td>{{ $e->nombre }}</td>
	    	<td>{{ $e->estado }}</td>
	    	<td>
	    		{{ HTML::linkAction('AsociacionesController@getModificar', 'Modificar', array($e->codigo)) }} /
	    		<a href="{{ URL::action('AsociacionesController@getEliminar', array($e->codigo)) }}" onclick="javascript:return confirm('¿Está seguro que desea eliminar la asociación {{ $e->nombre }}?');">Eliminar</a>
	    	</td>
	    </tr>
		@endforeach
	</table>
	{{ $asociaciones->links() }}<br><br>
	{{ HTML::linkAction('AsociacionesController@getAgregar', 'Nueva asociación') }}
@stop