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
    
    @if ($torneo->cantidad >= 8)
        @foreach ($fases as $f=>$fase)
            <div class="separador">{{ $fase['nombre'] }}</div>  
            @foreach ($fase['grupos'] as $g=>$grupo)
                <div class="grupo">{{ $g }}</div>
                @foreach ($grupo as $e=>$enfrentamiento)
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
                                {{ Form::text($g.$e.'-fecha') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="boton" colspan="2"><a id="agregar-set" href="javascript:void(0)"><i class="fa fa-plus"></i>Agregar sets</a></td>
                        </tr>
                    </tbody>
                </table>
                {{ Form::hidden($g.$e.'-cedula_participante_1', $enfrentamiento[0]['cedula']) }}
                {{ Form::hidden($g.$e.'-cedula_participante_2', $enfrentamiento[1]['cedula']) }}
                {{ Form::hidden($g.$e.'-codigo_torneo', $torneo->codigo) }}
                {{ Form::hidden($g.$e.'-fase', $f) }}
                {{ Form::hidden($g.$e.'-sets_jugados', null) }}
                @endforeach
            @endforeach            
        @endforeach    
    @else
        @foreach ($fases as $f=>$fase)        
            <div class="separador">{{ $fase['nombre'] }}</div>            
            @foreach ($fase['enfrentamientos'] as $e=>$enfrentamiento)
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
                            {{ Form::text($e.'-fecha') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="boton" colspan="2"><a id="agregar-set" href="javascript:void(0)"><i class="fa fa-plus"></i>Agregar sets</a></td>
                    </tr>
                </tbody>
            </table>
            {{ Form::hidden($e.'-cedula_participante_1', $enfrentamiento[0]['cedula']) }}
            {{ Form::hidden($e.'-cedula_participante_2', $enfrentamiento[1]['cedula']) }}
            {{ Form::hidden($e.'-codigo_torneo', $torneo->codigo) }}
            {{ Form::hidden($e.'-fase', $f) }}
            {{ Form::hidden($e.'-sets_jugados', null) }}
            @endforeach            
        @endforeach
    @endif

	{{ Form::close() }}
@stop

@section('javascript')
    {{ HTML::script('js/jquery.datetimepicker.js') }}
@stop