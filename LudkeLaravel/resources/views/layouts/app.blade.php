<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

   
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div id="app">
        
        @component('component.navbar')
        @endcomponent

        <main class="">
            
            @yield('content')
        </main>
    </div>

    @hasSection ('javascript')
        @yield('javascript')
    @else
        
    @endif



     <!-- Scripts -->
    
     <script src="{{ asset('js/app.js') }}" defer></script>
     <script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
     <script src="{{ asset('js/jquery.quicksearch.js')}}"></script>
 
     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
 
</body>
</html>
