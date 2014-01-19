@extends('layouts.default')

@section('css')
    {{ HTML::style('css/jquery.datetimepicker.css') }}
@stop

@section('title')
	Torneo
@stop

@section('description')
	Enfrentamientos del torneo
@stop

@section('breadcrumb')
	<li>
		<a href="{{ Session::get('page.url') }}">
			<i class="fa fa-arrow-circle-left"></i>
			<span>Volver</span>
		</a>
	</li>
    <li>
        <a class="save" href="javascript:void(0)" >
            <i class="fa fa-floppy-o"></i>
            <span>Guardar</span>
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
    
    


    {{ Form::open(array('action' => 'EnfrentamientosController@getAgregar', 'id' => 'frmAsoc')) }}    
    
    @if ($cantidad >= 8)
        @foreach ($fases as $fase)
            <div class="separador">{{ $fase['nombre'] }}</div>  
            @foreach ($fase['grupos'] as $key=>$grupo)
                <div class="grupo">{{ $key }}</div>
                @foreach ($grupo as $enfrentamiento)
                <table class="formulario principal left ">
                    <tbody>
                        <tr>
                            <td class="center" colspan="2">
                                {{ $enfrentamiento[0]['nombres'] }} {{ $enfrentamiento[0]['apellidos'] }}
                                <b>vs</b><br>
                                {{ $enfrentamiento[1]['nombres'] }} {{ $enfrentamiento[1]['apellidos'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha:</td>
                            <td class="fecha">
                                {{ Form::text('fecha') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="boton" colspan="2"><a id="agregar-set" href="javascript:void(0)"><i class="fa fa-plus"></i>Agregar set</a></td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            @endforeach            
        @endforeach    
    @else
        @foreach ($fases as $fase)        
            <div class="separador">{{ $fase['nombre'] }}</div>            
            @foreach ($fase['enfrentamientos'] as $enfrentamiento)
            <table class="formulario principal left ">
                <tbody>
                    <tr>
                        <td class="center" colspan="2">
                            {{ $enfrentamiento[0]['nombres'] }} {{ $enfrentamiento[0]['apellidos'] }}
                            <b>vs</b><br>
                            {{ $enfrentamiento[1]['nombres'] }} {{ $enfrentamiento[1]['apellidos'] }}
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha:</td>
                        <td class="fecha">
                            {{ Form::text('fecha') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="boton" colspan="2"><a id="agregar-set" href="javascript:void(0)"><i class="fa fa-plus"></i>Agregar set</a></td>
                    </tr>
                </tbody>
            </table>
            @endforeach            
        @endforeach
    @endif
    

    

	
	{{ Form::close() }}
@stop

@section('javascript')
    {{ HTML::script('js/jquery.datetimepicker.js') }}
@stop