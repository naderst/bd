@extends('layouts.default')

@section('content')
	@if ($errors->any())
	<div id="message" class="error">
		@foreach ($errors->all() as $message)
			{{ $message }} <br>
		@endforeach
	</div>
	@endif

	@if (isset($atletas))
		{{ Form::model($atletas, array(
			'action' => array(
				'AtletasController@getModificar',
				$atletas->cedula
			))
		)}}
	@else
		{{ Form::open(array('action' => 'AtletasController@getAgregar')) }}
	@endif

	{{ Form::label('cedula', 'Cédula') }}
	@if (isset($atletas))
		{{ Form::text('cedula', null, array('readonly' => 'readonly')) }}
	@else
		{{ Form::text('cedula') }}
	@endif
	<br>
	{{ Form::label('nombres', 'Nombres') }}
	{{ Form::text('nombres') }}
	<br>
	{{ Form::label('apellidos', 'Apellidos') }}
	{{ Form::text('apellidos') }}
	<br>
	{{ Form::label('fecha_nacimiento', 'Fecha de nacimiento (d/m/y)') }}
	{{ Form::text('fecha_nacimiento') }}
	<br>
	{{ Form::label('sexo', 'Sexo') }}
	{{ Form::radio('sexo', 'M', true) }} Masculino
	{{ Form::radio('sexo', 'F') }} Femenino
	<br>
	{{ Form::label('codigo_club', 'Club') }}
	{{ Form::select('codigo_club', $clubes) }}
	<br><br>
	{{ Form::submit('Guardar') }}
	<input type="button" onclick="javascript:document.location='{{ URL::to(Session::get('page.url')) }}'" value="Cancelar">

	{{ Form::close() }}
@stop