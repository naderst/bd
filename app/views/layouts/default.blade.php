<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Federación Venezolana de Tenis de Mesa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
    {{ HTML::style('css/ping-pong.css') }}
    {{ HTML::style('css/font-awesome.min.css') }}
</head>

<body>
    <header id="barra">
        <div class="contenido">
            <h1>
                <span>FVTM</span>
            </h1>
            <nav class="navegacion">
                <ul>
                    <li>
                        <a class="usuario" href="javascript:void(0)">
                            <img src="{{ URL::to('img/avatar.png') }}" alt="{{ Auth::user()->username }}">{{ Auth::user()->username }}
                            <i class="fa fa-angle-down"></i>
                        </a>
                    </li>
                    <li>
                        <a id="toggler" href="javascript:void(0)">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="fix"></div>
        </div>
    </header>
    <div id="usuario">
        <ul>
            <li>
                <a href="{{ URL::to('/logout') }}">
                    <i class="fa fa-sign-out"></i>Cerrar sesión</a>
            </li>
        </ul>
    </div>
    <div id="pagina">
        <aside id="aside">
            <nav class="navegacion">
                <ul>
                    <li>
                        <a href="{{ URL::to('/') }}"@if (Request::segment(1) == '') class="seleccionado"@endif>
                            <i class="fa fa-home"></i>Inicio
                            @if (Request::segment(1) == '')
                            <span class="flecha"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::action('AsociacionesController@getIndex') }}"@if (Request::segment(1) == 'asociaciones') class="seleccionado"@endif>
                            <i class="fa fa-users"></i>Asociaciones
                            @if (Request::segment(1) == 'asociaciones')
                            <span class="flecha"></span>
                            @endif</a>
                    </li>
                    <li>
                        <a href="{{ URL::action('ClubesController@getIndex') }}"@if (Request::segment(1) == 'clubes') class="seleccionado"@endif>
                            <i class="fa fa-shield"></i>Clubes
                            @if (Request::segment(1) == 'clubes')
                            <span class="flecha"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::action('AtletasController@getIndex') }}"@if (Request::segment(1) == 'atletas') class="seleccionado"@endif>
                            <i class="fa fa-male"></i>Atletas
                            @if (Request::segment(1) == 'atletas')
                            <span class="flecha"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::action('TorneosController@getIndex') }}"@if (Request::segment(1) == 'torneos') class="seleccionado"@endif>
                            <i class="fa fa-trophy"></i>Torneos</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="fa fa-sort-numeric-asc"></i>Ranking</a>
                    </li>
                </ul>
            </nav>
        </aside>
        <section id="principal">
            <h1 class="titulo">@yield('title')
                <small>@yield('description')</small>
            </h1>
            <nav class="breadcrumb">
                <ul>
                	@yield('breadcrumb')
                    <li class="fecha">
                        <i class="fa fa-calendar-o"></i>{{ date('d/m/Y', time()) }}</li>
                </ul>
            </nav>
            @if (Session::has('message'))
				<div id="message"@if (Session::has('message_type')) class="{{ Session::get('message_type') }}"@endif>
					{{ Session::get('message') }}
				</div>
			@endif
            @yield('content')
            <div id="maia-signature"></div>
            <div class="fix"></div>
        </section>
        <footer id="footer">Universidad Católica Andrés Bello</footer>
        <div class="fix"></div>
    </div>
    {{ HTML::script('js/jquery-2.0.3.min.js') }}
    {{ HTML::script('js/ping-pong.js') }}
</body>

</html>