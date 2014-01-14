@extends('layouts.default')

@section('title')
	Atletas
@stop

@section('description')
	Aquí se listan todos los atletas registrados. Puedes crear nuevos, editar y borrar existentes.
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
    @if(!isset($atletas))
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

	@if (isset($atletas))
		{{ Form::model($atletas, array(
			'action' => array(
				'AtletasController@getModificar',
				$atletas->cedula
			),
			'id' => 'frmAsoc')
		)}}
	@else
		{{ Form::open(array('action' => 'AtletasController@getAgregar', 'id' => 'frmAsoc')) }}
	@endif

	<table class="formulario">
	    <tbody>
	        <tr>
	            <td>Cédula:</td>
	            <td>
					@if (isset($atletas))
						{{ Form::text('cedula', null, array('readonly' => 'readonly')) }}
					@else
						{{ Form::text('cedula') }}
					@endif
	            </td>
	        </tr>
	        <tr>
	            <td>Nombres:</td>
	            <td>
	                {{ Form::text('nombres') }}
	            </td>
	        </tr>
	        <tr>
	        	<td>Apellidos:</td>
	        	<td>
	        		{{ Form::text('apellidos') }}
	        	</td>
	        </tr>
	        <tr>
	        	<td>Fecha de nacimiento (d/m/a):</td>
	        	<td>
	        		{{ Form::text('fecha_nacimiento') }}
	        	</td>
	        </tr>
	        <tr>
	        	<td>Sexo:</td>
	        	<td>
	        		{{ Form::radio('sexo', 'M', true) }} Masculino
					{{ Form::radio('sexo', 'F') }} Femenino
	        	</td>
	        </tr>
	        <tr>
	        	<td>Club:</td>
	        	<td>
	        		{{ Form::select('codigo_club', $clubes) }}
	        	</td>
	        </tr>
	    </tbody>

	</table>
	
	{{ Form::close() }}
@stop