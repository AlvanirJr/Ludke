@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="titulo-pagina-nome">
                            <h2>Finalizar Pagamento</h2>
                        </div>
                    </div>
                </div>
            </div><!-- end titulo-pagina -->
        </div><!-- end col-->
    </div><!-- end row-->
   
    <div class="row informacoes">
        <div class="col-sm-12">
            <h3>Informações do Pedido</h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Nome do Cliente</h5>
                  <p class="card-text"><h3>{{$pedido->cliente->user->name}}</h3></p>
                </div>
              </div>
        </div>
    
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Nome do Funcionário</h5>
                  <p class="card-text"><h3>{{$pedido->funcionario->user->name}}</h3></p>
                </div>
              </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-4">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Data do Pedido</h5>
                  <p class="card-text"><h3>{{$pedido->created_at->format('d/m/y')}}</h3></p>
                </div>
              </div>
            
        </div>
    
        <div class="col-sm-4">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Data de Entrega</h5>
                  <p class="card-text"><h3>{{date('d/m/Y', strtotime($pedido->dataEntrega))}}</h3></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Valor do Pedido</h5>
                  <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{$pedido->valorTotal}}</h3></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row informacoes">
        <div class="col-sm-12">
            <h3>Informações do Pagamento</h3>
        </div>
    </div>


    <form method="POST" action="{{route('vendas.concluirVendaPagamento')}}">    
        @csrf
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card cardFinalizarPedidos">
                    <div class="card-body">
                      <h5 class="card-title">Data</h5>
                      <p class="card-text">
                          <div class="row justify-content-center">
                              <div class="col-sm-12 form-group">
                                <label for=""></label>
                              </div>
                          </div>
                      </p>
                    </div>
                  </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('javascript')

<script type="text/javascript">
    
</script>    
@endsection