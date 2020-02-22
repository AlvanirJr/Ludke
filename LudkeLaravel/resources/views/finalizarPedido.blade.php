@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="titulo-pagina-nome">
                            <h2>Finalizar Pedido</h2>
                        </div>
                    </div>
                </div>
            </div><!-- end titulo-pagina -->
        </div><!-- end col-->
    </div><!-- end row-->
   

    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Nome do Cliente</h5>
                  <p class="card-text"><h3>{{$pedido->nomeCliente}}</h3></p>
                </div>
              </div>
        </div>
    
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Nome do Funcionário</h5>
                  <p class="card-text"><h3>{{$pedido->nomeFuncionario}}</h3></p>
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
                  <p class="card-text"><h3>R$ {{$pedido->valorTotal}}</h3></p>
                </div>
            </div>
        </div>
    </div>


    <form method="POST" action="{{route('concluirPedidoPesoFinal')}}">    
        @csrf
        <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card cardFinalizarPedidos">
                    <div class="card-body">
                    <h5 class="card-title">Itens do Pedido</h5>
                    <p class="card-text">
                        <table class="table table-responsive-lg">
                            <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">(R$) Preço/Kg</th>
                                <th scope="col">Peso Solicitado</th>
                                <th scope="col">Valor Estimado</th>
                                <th scope="col"> Peso Final</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pedido->itensPedidos as $item)
                                <tr>
                                    <td>{{$item->nomeProduto}}</td>
                                    <td>{{$item->precoProduto}}</td>
                                    <td>{{$item->pesoFinal}}</td> {{-- Durante o pedido, o peso final é igual ao peso solicitado. Somente na conclusão do pedido que o peso final é atualizado--}}
                                    <td>{{$item->valorReal}}</td>
                                    <td>
                                        <input id="pesoFinal{{$item->id}}" name="pesoFinal{{$item->id}}" step="0.01" type="number" class="form-control" placeholder="Peso Final">
                                        
                                        @error('pesoFinal{{$item->id}}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </p>
                    </div>
                </div>
                <?php //dd($pedido)?>
                
            </div>
        </div>

        <div class="row justify-content-center" style="margin:30px 0 30px 0;">
            <div class="col-sm-4" style="heigth:100px">
                <a href="{{route('listarPedidos')}}" class="btn btn-secondary-ludke btn-pedido" >Voltar</a>
            </div>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary-ludke btn-pedido">Concluir Pedido</button>
            </div>
        </div>
    </form>
</div>

@endsection