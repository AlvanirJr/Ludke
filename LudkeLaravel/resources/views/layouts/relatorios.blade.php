<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('titulo')</title>
	</head>
	<body>
		<h1 style="text-align:center;">@yield('titulo')</h1>
		<h2 style="text-align:center;">
			- Emitido em @yield('date') -
		</h2><br>
	    @yield('content')
	</body>
</html>