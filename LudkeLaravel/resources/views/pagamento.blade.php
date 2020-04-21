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
                  <h5 class="card-title">Cliente</h5>
                  <p class="card-text"><h3>{{$pedido->cliente->user->name}}</h3></p>
                </div>
              </div>
        </div>
    
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Funcionário Responsável pelo Pagamento</h5>
                  <p class="card-text"><h3>{{Auth::user()->name}}</h3></p>
                </div>
              </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Data do Pedido</h5>
                  <p class="card-text"><h3>{{$pedido->created_at->format('d/m/y')}}</h3></p>
                </div>
              </div>
            
        </div>
    
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Data de Entrega</h5>
                  <p class="card-text"><h3>{{date('d/m/Y', strtotime($pedido->dataEntrega))}}</h3></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-4">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Valor Total do Pedido</h5>
                  <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{$pedido->valorTotal}}</h3></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Valor do Desconto</h5>
                  <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDesconto">0</h3></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Valor Pago</h5>
                  <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorTotalPago">0</h3></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row informacoes">
        <div class="col-sm-12">
            <h3>Informações do Pagamento</h3>
        </div>
    </div>


    <form id="formPagamento" action="{{route('vendas.pagamento')}}" method="POST">    
        @csrf
        <input type="hidden" name="valorTotalPagamento" value="{{$pedido->valorTotal}}">
        <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
        {{-- 'funcionario_id' é o id do funcionario logado responsável pelo pagamento--}}
        <input type="hidden" name="funcionario_id" value="{{Auth::user()->funcionario->id}}">
        <div class="row justify-content-center">
            <div class="col-sm-4 form-group">
                <label for="dataVencimento">Data de Vencimento <span class="obrigatorio">*</span></label>
                <input type="date" class="form-control" id="dataVencimento" name="dataVencimento">
                <span style="color:red" id="spanDataVencimento"></span>
            </div>
            <div class="col-sm-4 form-group">
                <label for="dataPagamento">Data de Pagamento <span class="obrigatorio">*</span></label>
                <input type="date" class="form-control" id="dataPagamento" name="dataPagamento">
                <span style="color:red" id="spanDataPagamento"></span>
            </div>

            <div class="col-sm-4 form-group">
                <label for="statusPagamento">Tipo de Pagamento <span class="obrigatorio">*</span></label>
                <select name="statusPagamento" class="form-control" id="statusPagamento">
                    <option value="" selected disabled>-- Tipo de Pagamento --</option>
                    <option value="CARTÃO DE CRÉDITO">CARTÃO DE CRÉDITO</option>
                    <option value="BOLETO">BOLETO</option>
                    <option value="À VISTA">À VISTA</option>
                    <option value="À PRAZO">À PRAZO</option>
                </select>
                <span style="color:red" id="spanStatusPagamento"></span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-6 form-group">
                <label for="descontoPagamento">Desconto %</label>
                <input id="descontoPagamento" type="number" oninput="atualizarValorDesconto({{$pedido->valorTotal}})" class="form-control" name="descontoPagamento" value="0">
                <span style="color:red" id="spanDescontoPagamento"></span>
            </div>
            <div class="col-sm-6 form-group">
                <label for="valorPago">Valor Pago (R$) <span class="obrigatorio">*</span></label>
                <input type="number" id="valorPago" oninput="atualizaValorPago({{$pedido->valorTotal}})" class="form-control" name="valorPago">
                <span style="color:red" id="spanValorPago"></span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12 form-group">
                <label for="obs">Observações</label>
                <textarea class="form-control" name="obs" id="" rows="5"></textarea>
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

    $(function(){
        $('#formPagamento').submit(function(event){
            if(!isValid()){
                event.preventDefault();
                // $("#formPagamento").submit();
            }
            console.log({
                dataVencimento: $('#dataVencimento').val(),
                dataPagamento: $('#dataPagamento').val(),
                statusPagamento: $('#statusPagamento').val(),
                valorPago: $('#valorPago').val(),
                descontoPagamento: $('#descontoPagamento').val()
            })

            


        });
    });

    function isValid(){
        let isValid = true;
        if($('#dataVencimento').val() == ""){
            isValid = false;
            $("#spanDataVencimento").html("Selecione a Data de Vencimento")
        }
        if($('#dataVencimento').val() != ""){
            $("#spanDataVencimento").html("")
        }
        if($('#dataPagamento').val() == ""){
            isValid = false;
            $("#spanDataPagamento").html("Selecione a Data de Pagamento")
        }
        if($('#dataPagamento').val() != ""){
            $("#spanDataPagamento").html("")
        }
        if($('#statusPagamento').val() == null){
            isValid = false;
            $("#spanStatusPagamento").html("Selecione o Tipo de Pagamento")
        }
        if($('#statusPagamento').val() != null){
            $("#spanStatusPagamento").html("")
        }
        if($('#valorPago').val() == ""){
            isValid = false;
            $("#spanValorPago").html("Preencha o Valor do Pagamento")
        }
        if($('#valorPago').val() != ""){
            $("#spanValorPago").html("")
        }
        if($('#descontoPagamento').val() == ""){
            isValid = false;
            $("#spanDescontoPagamento").html("Preencha o Desconto do Pagamento")
        }
        if($('#descontoPagamento').val() != ""){
            $("#spanDescontoPagamento").html("")
        }

        return isValid;
    }

    // calcula o desconto
    function calcularDesconto(valorTotal){
        let desconto = $('#descontoPagamento').val();
        if(desconto > 100){
            return null;
        }else{
            return (valorTotal * (desconto/100));

        }
    }

    // atualiza o valor do desconto ao inserir o desconto
    function atualizarValorDesconto(valorTotal){
        
        let valorDesconto = calcularDesconto(valorTotal);

        if(valorDesconto != null){
            // Atualiza na tela o valor do desconto
            $('#valorDesconto').html(valorDesconto);
        }else{
            alert('Não é possível aplicar um desconto maior do que 100%');
            $('#descontoPagamento').val(0);
            $('#valorDesconto').html(0);
        }
    }

    // atualiza o valor pago
    function atualizaValorPago(valorTotal){
        let valorPago = $('#valorPago').val();
        let valorComDesconto = valorTotal - calcularDesconto(valorTotal)
        if(valorPago > valorComDesconto ){
            alert(`Você não pode inserir um valor maior do que o valor do pedido: R$ ${valorComDesconto}`);
            $('#valorPago').val('');
            $('#valorTotalPago').html(0);
        }else{
            $('#valorTotalPago').html(valorPago);
        }
    }
</script>    
@endsection