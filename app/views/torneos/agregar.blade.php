@extends('layouts.default')

@section('css')
    {{ HTML::style('css/jquery.datetimepicker.css') }}
@stop

@section('title')
	Torneo
@stop

@section('description')
	Nuevo torneo
@stop

@section('breadcrumb')
	<li>
		<a href="{{ Session::get('page.url') }}">
			<i class="fa fa-arrow-circle-left"></i>
			<span>Volver</span>
		</a>
	</li>
    <li>
        <a href="javascript:void(0)">
            <i class="fa fa-bolt"></i>
            <span>Modo en vivo</span>
        </a>
    </li>
    <li>
        <a class="save" href="javascript:void(0)" >
            <i class="fa fa-floppy-o"></i>
            <span>Guardar</span>
        </a>
    </li>
    <li>
        <a class="saveandreturn" href="javascript:void(0)">
            <i class="fa fa-plus-square"></i>
            <span>Guardar y agregar otro</span>
        </a>
    </li>
@stop

@section('content')
	@if ($errors->any())
	<div id="message" class="error">
		@foreach ($errors->all() as $message)
			{{ $message }} <br>
		@endforeach
	</div>
	@endif


    {{ Form::open(array('action' => 'TorneosController@getAgregar', 'id' => 'frmAsoc')) }}

	<table class="formulario principal left ">
	    <tbody>
	        <tr>
	            <td>Descripción:</td>
	            <td>
	                {{ Form::text('descripcion') }}
	            </td>
	        </tr>
            <tr>
	            <td>Fecha de inicio:</td>
	            <td class="fecha">
	                {{ Form::text('fecha_inicio') }}
	            </td>
	        </tr>
            <tr>
	            <td>Fecha de fin:</td>
	            <td class="fecha">
	                {{ Form::text('fecha_fin') }}
	            </td>
	        </tr>
            <tr>
	            <td>Tipo de torneo:</td>
	            <td>
	                {{ Form::select('tipo', $tipos) }}
	            </td>
	        </tr>
	        <tr>
	            <td class="boton" colspan="2"><a id="agregar-participante" href="javascript:void(0)"><i class="fa fa-plus"></i>Agregar participantes</a></td>
	        </tr>
            <tr>
	            <td class="boton" colspan="2"><a id="eliminar-participante" class="eliminar" href="javascript:void(0)"><i class="fa fa-times"></i>Eliminar participantes</a></td>
	        </tr>
	    </tbody>
	</table>
	
	<section class="contenedor"></section>
	
	{{ Form::hidden('cantidad', null, array('id' => 'cantidad')) }}
	{{ Form::close() }}
@stop

@section('javascript')
    <script>rutaClubes = "{{ URL::action('ClubesController@getJson') }}"; rutaAtletas = "{{ URL::action('AtletasController@getJson') }}";</script>
    {{ HTML::script('js/jquery.datetimepicker.js') }}
    {{ HTML::script('js/ping-pong.torneos.js') }}
@stop