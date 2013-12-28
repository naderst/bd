@extends('layouts.login')

@section('content')
	{{ Form::open(array('route' => 'login',  'method' => 'POST')) }}

    <p>
        {{ Form::label('username', 'Nombre de usuario') }}<br/>
        {{ Form::text('username', Input::old('username')) }}
    </p>

    <p>
        {{ Form::label('password', 'Contraseña') }}<br/>
        {{ Form::password('password') }}
    </p>

    <p>
    	{{ Form::checkbox('remember') }}
    	{{ Form::label('remember', 'Recordar mi contraseña') }}
    </p>

    <p>{{ Form::submit('Iniciar sesión') }}</p>

	{{ Form::close() }}
@stop