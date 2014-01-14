@extends('layouts.default')

@section('title')
	Asociaciones
@stop

@section('description')
	Aquí se listan todas las asociaciones registradas. Puedes crear nuevas, editar y borrar existentes.
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
    @if(!isset($asoc))
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

	@if (isset($asoc))
		{{ Form::model($asoc, array(
			'action' => array(
				'AsociacionesController@getModificar',
				$asoc->codigo
			),
			'id' => 'frmAsoc'
		))}}
	@else
		{{ Form::open(array('action' => 'AsociacionesController@getAgregar', 'id' => 'frmAsoc')) }}
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
	            <td>Estado:</td>
	            <td>
	                {{ Form::select('estado', $estados) }}
	            </td>
	        </tr>
	    </tbody>

	</table>
	{{ Form::close() }}
@stop