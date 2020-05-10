
<nav class="navbar navbar-expand-md navbar-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home')}}">
            <img id="logo" src="{{asset('img/logo_navbar.png')}}" style="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->

            {{-- @if(Auth::check()) --}}
            @can('view_admin', Auth::user())
                <ul class="navbar-nav mr-auto">
                    {{-- Inicio --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">Início</a>
                    </li>
                    {{-- Cruds --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="navbarDropdownGerenciar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gerenciar
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('produtos')}}">Produtos</a>
                            <a class="dropdown-item" href="{{route('categorias')}}">Categorias</a>
                            <a class="dropdown-item" href="{{route('clientes')}}">Clientes</a>
                            <a class="dropdown-item" href="{{route('funcionarios')}}">Funcionários</a>
                            <a class="dropdown-item" href="{{route('cargos')}}">Cargos</a>
                        </div>
                    </li>
                    {{-- Pedidos --}}
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="navbarDropdownGerenciar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pedidos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('pedidos')}}">Novo Pedido</a>
                            <a class="dropdown-item" href="{{route('listarPedidos')}}">Listar Pedidos</a>
                        </div>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('listarPedidos')}}">Pedidos</a>
                    </li>
                    {{-- Vendas --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="navbarDropdownGerenciar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Vendas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('vendas')}}">Nova Venda</a>
                            <a class="dropdown-item" href="{{route('listarVendas')}}">Listar Vendas</a>
                        </div>
                    </li>
                    {{-- Relatórios --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="navbarDropdownGerenciar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Relatórios
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('relatorioCliente')}}" target="_blank">Clientes</a>
                        </div>

                    </li>
                    {{-- Ajuda --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ajuda</a>
                    </li>
                </ul>
            @endcan


            @can('view_gerenteAdmin', Auth::user())
                <ul class="navbar-nav mr-auto">
                    {{-- Inicio --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">Início</a>
                    </li>
                    {{-- Cruds --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gerenciar
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('produtos')}}">Produtos</a>
                            <a class="dropdown-item" href="{{route('categorias')}}">Categorias</a>
                            <a class="dropdown-item" href="{{route('funcionarios')}}">Funcionários</a>
                            <a class="dropdown-item" href="{{route('clientes')}}">Clientes</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('listarPedidos')}}">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Relatórios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ajuda</a>
                    </li>
                </ul>
        @endcan


            @can('view_vendedor', Auth::user())
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">Início</a>
                    </li>
                    <li class="nav-item dropdown">

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('produtos')}}">Produtos</a>
                            <a class="dropdown-item" href="{{route('categorias')}}">Categorias</a>
                            <a class="dropdown-item" href="{{route('clientes')}}">Clientes</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('listarPedidos')}}">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Relatórios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ajuda</a>
                    </li>
                </ul>
        @endcan

            @can('view_salsicheiro', Auth::user())
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">Início</a>
                    </li>
                    <li class="nav-item dropdown">

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('produtos')}}">Produtos</a>

                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('listarPedidos')}}">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ajuda</a>
                    </li>
                </ul>
        @endcan

            @can('view_gerenteGeral', Auth::user())
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">Início</a>
                    </li>
                    <li class="nav-item dropdown">

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('produtos')}}">Produtos</a>
                            <a class="dropdown-item" href="{{route('categorias')}}">Categorias</a>
                            <a class="dropdown-item" href="{{route('clientes')}}">Clientes</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('listarPedidos')}}">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Relatórios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ajuda</a>
                    </li>
                </ul>
        @endcan
            {{-- @endif --}}
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
