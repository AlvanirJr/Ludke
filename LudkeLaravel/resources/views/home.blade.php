@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

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
            {{-- Desabilitado --}}
            <div class="col-sm-4">
                <div id="card" style="background-color:#aaa; box-shadow: none" onclick="alerta()">
                    <a id="link-card" href="">
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
            {{-- Desabilitado --}}
            <div class="col-sm-4">
                <div id="card" style="background-color:#aaa; box-shadow: none" onclick="alerta()">
                    <a id="link-card" href="">
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
                <div id="card" style="background-color:#aaa; box-shadow: none" onclick="alerta()">
                    <a id="link-card" href="">
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
            {{-- Desabilitado --}}
            <div class="col-sm-4">
                <div id="card" style="background-color:#aaa; box-shadow: none" onclick="alerta()">
                    <a id="link-card" href="">
                        <div class="row justify-content-center">
                            <img id="card-image" src="{{ asset("img/lojas.png")  }}" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div id="card-text">Lojas</div>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
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
