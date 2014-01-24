@extends('layouts.default')

@section('title')
	Clubes
@stop

@section('description')
	@if(!isset($clubes))
		Aquí se agregan clubes
	@else
		Aquí se editan clubes
	@endif
@stop

@section('breadcrumb')
	<li>
		<a href="{{ Session::get('page.url') }}">
			<i class="fa fa-arrow-circle-left"></i>
			<span>Volver</span>
		</a>
	</li>
    <li>
        <a href="javascript:void(0)" class="save">
            <i class="fa fa-floppy-o"></i>
            <span>Guardar</span>
        </a>
    </li>
    @if(!isset($clubes))
    <li>
        <a href="javascript:void(0)" class="saveandreturn">
            <i class="fa fa-plus-square"></i>
            <span>Guardar y agregar otro</span>
        </a>
    </li>
    @endif
@stop

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
			),
			'id' => 'frmAsoc'
		))}}
	@else
		{{ Form::open(array('action' => 'ClubesController@getAgregar', 'id' => 'frmAsoc')) }}
	@endif

	<table class="formulario">
	    <tbody>
	        <tr>
	            <td>Nombre:</td>
	            <td>
	                {{ Form::text('nombre') }}
	            </td>
	        </tr>
	        <tr>
	            <td>Asociación:</td>
	            <td>
	                {{ Form::select('codigo_asociacion', $asociaciones) }}
	            </td>
	        </tr>
	    </tbody>

	</table>
	{{ Form::close() }}
@stop