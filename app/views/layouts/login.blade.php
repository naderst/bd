<!doctype html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		{{ HTML::style('css/style.css') }}
	</head>
	<body>
		@if (Session::has('login_message'))
			<div id="message" class="error">
				{{ Session::get('login_message') }}
			</div>
		@endif

		@yield('content')
	</body>
</html>
