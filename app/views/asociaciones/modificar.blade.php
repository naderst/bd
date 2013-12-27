@extends('layouts.default')

@section('content')
	@if ($errors->any())
		Hay errores: {{ print_r($errors) }}
	@endif

	@if (isset($asoc))
		{{ Form::model($asoc, array(
			'action' => array(
				'AsociacionesController@getModificar',
				$asoc->codigo
			))
		)}}
	@else
		{{ Form::open(array('action' => 'AsociacionesController@getAgregar')) }}
	@endif

	{{ Form::label('nombre', 'Nombre') }}
	{{ Form::text('nombre') }}
	<br>
	{{ Form::label('estado', 'Estado') }}
	{{ Form::select('estado', $estados) }}
	<br>
	{{ Form::submit('Guardar') }}
	<input type="button" onclick="javascript:document.location='{{ URL::action('AsociacionesController@getIndex') }}'" value="Cancelar">

	{{ Form::close() }}
@stop