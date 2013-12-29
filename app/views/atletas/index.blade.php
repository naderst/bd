@extends('layouts.default')

@section('content')
	<table cellspacing="0" cellpadding="5" border="1">
    	<tr>
    		<th>Cédula</th>
    		<th>Nombres</th>
    		<th>Apellidos</th>
    		<th>Fecha Nac.</th>
    		<th>Sexo</th>
    		<th>Club</th>
    		<th>Acción</th>
    	</tr>
	    @foreach ($atletas as $e)
	    <tr>
	    	<td>{{ $e->cedula }}</td>
	    	<td>{{ $e->nombres }}</td>
	    	<td>{{ $e->apellidos }}</td>
	    	<td>{{ date('d/m/Y', strtotime($e->fecha_nacimiento)) }}</td>
	    	<td>{{ $e->sexo }}</td>
	    	<td>{{ $e->club->nombre }}</td>
	    	<td>
	    		{{ HTML::linkAction('AtletasController@getModificar', 'Modificar', array($e->cedula)) }} /
	    		<a href="{{ URL::action('AtletasController@getEliminar', array($e->cedula)) }}" onclick="javascript:return confirm('¿Está seguro que desea eliminar el atleta {{ $e->nombres }} {{ $e->apellidos }} ({{ $e->cedula }})?');">Eliminar</a>
	    	</td>
	    </tr>
		@endforeach
	</table>
	{{ $atletas->links() }}<br><br>
	{{ HTML::linkAction('AtletasController@getAgregar', 'Nuevo atleta') }}

@stop