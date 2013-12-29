@extends('layouts.default')

@section('content')
	<table cellspacing="0" cellpadding="5" border="1">
    	<tr>
    		<th>Nombre</th>
    		<th>Asociación</th>
    		<th>Acción</th>
    	</tr>
	    @foreach ($clubes as $e)
	    <tr>
	    	<td>{{ $e->nombre }}</td>
	    	<td>{{ $e->asociacion->nombre }}</td>
	    	<td>
	    		{{ HTML::linkAction('ClubesController@getModificar', 'Modificar', array($e->codigo)) }} /
	    		<a href="{{ URL::action('ClubesController@getEliminar', array($e->codigo)) }}" onclick="javascript:return confirm('¿Está seguro que desea eliminar el club {{ $e->nombre }}?');">Eliminar</a>
	    	</td>
	    </tr>
		@endforeach
	</table>
	{{ $clubes->links() }}<br><br>
	{{ HTML::linkAction('ClubesController@getAgregar', 'Nuevo club') }}

@stop