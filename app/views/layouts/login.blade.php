<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Federación Venezolana de Tenis de Mesa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
    {{ HTML::style('css/autenticacion.css') }}
	{{ HTML::style('css/font-awesome.min.css') }}
</head>

<body>
    <img src="{{ URL::to('img/body-bg.png') }}" alt="" class="fondo">
    <div id="pagina">
        <h1 id="titulo"><span>FVTM</span></h1>
        <h2 id="subtitulo">Sistema administrativo</h2>
		@yield('content')
    </div>
    {{ HTML::script('js/jquery-2.0.3.min.js') }}
    {{ HTML::script('js/autenticacion.js') }}
</body>

</html>