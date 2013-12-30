@extends('layouts.default')

@section('content')
	@if ($errors->any())
	<div id="message" class="error">
		@foreach ($errors->all() as $message)
			{{ $message }} <br>
		@endforeach
	</div>
	@endif

	@if (isset($clubes))
		{{ Form::model($clubes, array(
			'action' => array(
				'ClubesController@getModificar',
				$clubes->codigo
			))
		)}}
	@else
		{{ Form::open(array('action' => 'ClubesController@getAgregar')) }}
	@endif

	{{ Form::label('nombre', 'Nombre') }}
	{{ Form::text('nombre') }}
	<br>
	{{ Form::label('codigo_asociacion', 'Asociación') }}
	{{ Form::select('codigo_asociacion', $asociaciones) }}
	<br>
	{{ Form::submit('Guardar') }}
	<input type="button" onclick="javascript:document.location='{{ URL::to(Session::get('page.url')) }}'" value="Cancelar">

	{{ Form::close() }}
@stop