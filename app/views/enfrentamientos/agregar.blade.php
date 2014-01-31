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

    {{ Form::open(array('action' => 'EnfrentamientosController@getAgregar', 'id' => 'frmEnfrentamientos')) }}

    {{ Form::hidden('codigo', $torneo->codigo) }}

    @if ($torneo->cantidad >= 8)
        @foreach ($fases as $f=>$fase)
            <div class="separador">{{ $fase['nombre'] }}</div>

            @if ($f == 0)
                @foreach ($fase['grupos'] as $g=>$grupo)
                    <div class="grupo">{{ $g }}</div>
                    @foreach ($grupo as $e=>$enfrentamiento)
                    <table class="formulario enfrentamiento left" data-id="{{$f.'-'.$g.'-'.$e}}">
                        <tbody>
                            <tr>
                                <td class="center" colspan="2">
                                    {{ $enfrentamiento[0]->nombres }} {{ $enfrentamiento[0]->apellidos }}
                                    <b>vs</b><br>
                                    {{ $enfrentamiento[1]->nombres }} {{ $enfrentamiento[1]->apellidos }}
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha:</td>
                                <td class="fecha">
                                    {{ Form::text($f.'-'.$g.'-'.$e.'-fecha') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="boton" colspan="2">
                                    <a class="agregar-sets" data-id="{{$f.'-'.$g.'-'.$e}}" href="javascript:void(0)"><i class="fa fa-plus"></i>Agregar set</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="boton" colspan="2">
                                    <a class="eliminar-sets eliminar" data-id="{{$f.'-'.$g.'-'.$e}}" href="javascript:void(0)"><i class="fa fa-plus"></i>Eliminar set</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {{ Form::hidden($f.'-'.$g.'-'.$e.'-cedula_participante_1', $enfrentamiento[0]->cedula) }}
                    {{ Form::hidden($f.'-'.$g.'-'.$e.'-cedula_participante_2', $enfrentamiento[1]->cedula) }}
                    {{ Form::hidden($f.'-'.$g.'-'.$e.'-fase', $f) }}
                    {{ Form::hidden($f.'-'.$g.'-'.$e.'-sets_jugados', 0) }}
                    @endforeach
                @endforeach
            @else
                @foreach ($fase['enfrentamientos'] as $e=>$enfrentamiento)
                <table class="formulario enfrentamiento left" data-id="{{$f.'-'.$e}}">
                    <tbody>
                        <tr>
                            <td class="center" colspan="2">
                                <select name="{{$f.'-'.$e.'-cedula_participante_1'}}" disabled>
                                    <option value="-1" selected>Sin determinar</option>
                                    @foreach ($enfrentamiento as $participante)
                                        <option value="{{$participante->cedula}}">{{$participante->nombres}} {{$participante->apellidos}}</option>
                                    @endforeach
                                </select>
                                <b>vs</b><br>
                                 <select name="{{$f.'-'.$e.'-cedula_participante_2'}}" disabled>
                                    <option value="-1" selected>Sin determinar</option>
                                    @foreach ($enfrentamiento as $participante)
                                        <option value="{{$participante->cedula}}">{{$participante->nombres}} {{$participante->apellidos}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha:</td>
                            <td class="fecha">
                                {{ Form::text($f.'-'.$e.'-fecha') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="boton" colspan="2"><a class="agregar-sets" data-id="{{$f.'-'.$e}}" href="javascript:void(0)"><i class="fa fa-plus"></i>Agregar set</a></td>
                        </tr>
                         <tr>
                            <td class="boton" colspan="2">
                                <a class="eliminar-sets eliminar" data-id="{{$f.'-'.$e}}" href="javascript:void(0)"><i class="fa fa-plus"></i>Eliminar set</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                {{ Form::hidden($f.'-'.$e.'-fase', $f) }}
                {{ Form::hidden($f.'-'.$e.'-sets_jugados', 0) }}
                @endforeach
            @endif
        @endforeach
    @else
        @foreach ($fases as $f=>$fase)
            <div class="separador">{{ $fase['nombre'] }}</div>
            @foreach ($fase['enfrentamientos'] as $e=>$enfrentamiento)
            <table class="formulario enfrentamiento left" data-id="{{$f.'-'.$e}}">
                <tbody>
                    <tr>
                        <td class="center" colspan="2">
                            {{ $enfrentamiento[0]->nombres }} {{ $enfrentamiento[0]->apellidos }}
                            <b>vs</b><br>
                            {{ $enfrentamiento[1]->nombres }} {{ $enfrentamiento[1]->apellidos }}
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha:</td>
                        <td class="fecha">
                            {{ Form::text($f.'-'.$e.'-fecha') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="boton" colspan="2">
                            <a class="agregar-sets" data-id="{{$f.'-'.$e}}" href="javascript:void(0)"><i class="fa fa-plus"></i>Agregar set</a>
                        </td>
                    </tr>
                     <tr>
                        <td class="boton" colspan="2">
                            <a class="eliminar-sets eliminar" data-id="{{$f.'-'.$e}}" href="javascript:void(0)"><i class="fa fa-plus"></i>Eliminar set</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            {{ Form::hidden($f.'-'.$e.'-cedula_participante_1', $enfrentamiento[0]->cedula) }}
            {{ Form::hidden($f.'-'.$e.'-cedula_participante_2', $enfrentamiento[1]->cedula) }}
            {{ Form::hidden($f.'-'.$e.'-fase', $f) }}
            {{ Form::hidden($f.'-'.$e.'-sets_jugados', 0) }}
            @endforeach
        @endforeach
    @endif

    {{ Form::close() }}
@stop

@section('javascript')
    <script>rutaEnfrentamiento = "{{ URL::action('EnfrentamientosController@getJson') }}";rutaSet = "{{ URL::action('SetsController@getJson') }}";</script>
    {{ HTML::script('js/jquery.datetimepicker.js') }}
    {{ HTML::script('js/jquery.numeric.js') }}
    {{ HTML::script('js/ping-pong.enfrentamientos.js') }}
@stop
