@extends('layouts.login')

@section('content')
    {{ Form::open(array('route' => 'login',  'method' => 'POST', 'id' => 'login')) }}
    @if (Session::has('login_message'))
        <div id="message" class="error">
            {{ Session::get('login_message') }}
        </div>
    @endif
    <div class="campo">
        <i class="fa fa-user"></i>
        {{ Form::text('username', 'Usuario') }}
    </div>
    <div class="campo">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" value="contraseña">
    </div>
    <a id="iniciar-sesion" href="javascript:void(0)" class="boton">Iniciar sesión</a>
    <div class="fix"></div>
    {{ Form::close() }}	
@stop