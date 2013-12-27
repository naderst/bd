@extends('layouts.default')

@section('content')
@if ($errors->any())
	Hay errores: {{ print_r($errors) }}
@endif
{{ Form::model($asoc, array(
	'action' => array(
		'AsociacionesController@getModificar',
		$asoc->codigo
	))
)}}

{{ Form::label('nombre', 'Nombre') }}
{{ Form::text('nombre') }}
<br>
{{ Form::label('estado', 'Estado') }}
{{ Form::select('estado', $estados) }}
<br>
{{ Form::submit('Guardar') }}

{{ Form::close() }}
@stop