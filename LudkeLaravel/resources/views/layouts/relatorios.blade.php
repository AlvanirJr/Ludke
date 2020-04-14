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
        <div align="center">
            <img src="{{asset('img/ludke-red.png')}}"  width=30% height=30% align="center" style="margin-top:10px">
        </div>
		<h2 style="text-align:center;">
			- Emitido em @yield('date') -
		</h2><br>
	    @yield('content')
	</body>


</html>
