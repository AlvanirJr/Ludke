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
    
    @if(isset($sucess))
        @if($sucess == false)
            <h4>Erro: O valor Pago é maior do que o valor do pedido!</h4>
        @endif
    @endif
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


    <form action="{{route('vendas.pagamento')}}" method="POST">    
        @csrf
        <input type="hidden" name="valorTotalPagamento" value="{{$pedido->valorTotal}}">
        <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
        <input type="hidden" name="funcionario_id" value="{{$pedido->funcionario_id}}">
        <div class="row justify-content-center">
            <div class="col-sm-4 form-group">
                <label for="dataVencimento">Data de Vencimento</label>
                <input type="date" class="form-control @error('dataVencimento') is-invalid @enderror" name="dataVencimento">
                
                @error('dataVencimento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-4 form-group">
                <label for="dataVencimento">Data de Pagamento</label>
                <input type="date" class="form-control @error('dataPagamento') is-invalid @enderror" name="dataPagamento">
                @error('dataPagamento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="col-sm-4 form-group">
                <label for="statusPagamento">Status</label>
                <select name="statusPagamento" class="form-control @error('statusPagamento') is-invalid @enderror" id="">
                    <option value="" selected disabled>-- Status --</option>
                    <option value="CARTÃO DE CRÉDITO">CARTÃO DE CRÉDITO</option>
                    <option value="BOLETO">BOLETO</option>
                    <option value="À VISTA">À VISTA</option>
                    <option value="À PRAZO">À PRAZO</option>
                </select>
                
                @error('statusPagamento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-6 form-group">
                <label for="valorPago">Valor Pago (R$)</label>
                <input type="number" class="form-control @error('valorPago') is-invalid @enderror" name="valorPago">
                
                @error('valorPago')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6 form-group">
                <label for="descontoPagamento">Desconto %</label>
                <input type="number" class="form-control @error('descontoPagamento') is-invalid @enderror" name="descontoPagamento" value="0">
                @error('descontoPagamento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12 form-group">
                <label for="obs">Observações</label>
                <textarea class="form-control @error('obs') is-invalid @enderror" name="obs" id="" rows="5"></textarea>

                @error('descontoPagamento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row justify-content-center" style="margin:30px 0 30px 0;">
            <div class="col-sm-6" style="heigth:100px">
                <a href="{{route('listarVendas')}}" class="btn btn-secondary-ludke btn-pedido" >Voltar</a>
            </div>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary-ludke btn-pedido">Finalizar Pagamento</button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('javascript')

<script type="text/javascript">
    
</script>    
@endsection