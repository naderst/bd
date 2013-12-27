<!doctype html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		{{ HTML::style('css/estilo.css') }}
	</head>
	<body>
		@if (Session::has('message'))
			<div id="message">
				{{ Session::get('message') }}
			</div>
		@endif
		@yield('content')
	</body>
</html>
