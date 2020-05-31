@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- @if(Auth::user()->can('view_salsicheiro', Auth::user())) --}}
        
        @if(Auth::user()->can('view_admin', Auth::user())
        || Auth::user()->can('view_gerenteAdmin', Auth::user())
        || Auth::user()->can('view_vendedor', Auth::user()))

        {{-- Linha 1 --}}
        <div class="row justify-content-center">
            {{-- Card Produtos --}}
            <div class="col-sm-4">
                <div id="card">
                    <a id="link-card" href="{{ route("produtos")}}">
                        <div class="row justify-content-center">
                            <img id="card-image" src="{{ asset("img/produtos.png")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Produtos</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Card Categorias --}}
            <div class="col-sm-4">
                <div id="card">
                    <a id="link-card" href="{{ route("categorias")}}">
                        <div class="row justify-content-center">
                            <img id="card-image-categorias" src="{{ asset("img/categorias.png")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Categorias</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Card 3 --}}
            
            <div class="col-sm-4">
                <div id="card">
                    <a id="link-card" href="{{route('clientes')}}">
                        <div class="row justify-content-center">
                            <img id="card-image" src="{{ asset("img/clientes.png")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Clientes</div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        {{-- Linha 2 --}}
        <div class="row justify-content-center">
            {{-- Card 1 --}}
            {{-- Funcionários --}}
            <div class="col-sm-4">
                <div id="card">
                    <a id="link-card" href="{{ route("funcionarios")}}">
                        <div class="row justify-content-center">
                            <img id="card-image" src="{{ asset("img/funcionarios.png")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Funcionários</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Card 2 --}}
            {{-- Desabilitado --}}
            <div class="col-sm-4">
                <div id="card" >
                    <a id="link-card" href="{{route("cargos")}}">
                        <div class="row justify-content-center">
                            <img id="card-image" src="{{ asset("img/cargos.png")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Cargos</div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- Card 3 --}}
            {{-- Pedidos --}}
            <div class="col-sm-4">
                <div id="card">
                    <a id="link-card" href="{{route("listarPedidos")}}">
                        <div class="row justify-content-center">
                            <img id="card-image" src="{{ asset("img/cash-register-solid.svg")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Pedidos</div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        @else
        <div class="row justify-content-center">
            {{-- Pedidos --}}
            <div class="col-sm-6">
                <div id="card">
                    <a id="link-card" href="{{route("listarPedidos")}}">
                        <div class="row justify-content-center">
                            <img id="card-image" src="{{ asset("img/cash-register-solid.svg")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Pedidos</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Pedidos --}}
            <div class="col-sm-6">
                <div id="card">
                    <a id="link-card" href="{{route("listarVendas")}}">
                        <div class="row justify-content-center">
                            <img id="card-image" src="{{ asset("img/cash-register-solid.svg")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Vendas</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('javascript')
<script>
    function alerta(){
        alert("Funcionalidade em desenvolvimento");
    }
</script>
@endsection
