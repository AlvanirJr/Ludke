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

    {{-- INFORMAÇÕES DO PEDIDO --}}
    <div class="row informacoes">
        <div class="col-sm-12">
            <h3>Informações do Pedido</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        {{-- Nome do Cliente --}}
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Cliente</h5>
                  <p class="card-text"><h3>{{$pedido->cliente->user->name}}</h3></p>
                </div>
              </div>
        </div>
        
        {{-- Funcionário responsável pelo pagamento --}}
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
        {{-- Data do pedido --}}
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                  <h5 class="card-title">Data do Pedido</h5>
                  <p class="card-text"><h3>{{$pedido->created_at->format('d/m/y')}}</h3></p>
                </div>
              </div>
        </div>

        {{--  Data de entrega do pedido--}}
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
        {{-- Valor Total do PEDIDO --}}
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                    @if($pedido->status->status == "PAGO PARCIALMENTE" && isset($pagamento->valorTotalPagamento))
                        <h5 class="card-title">Valor Total do Pedido</h5>
                        <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{money_format("%i",$pedido->valorTotal)}}</h3></p>
                    @else
                        <h5 class="card-title">Valor Total do Pedido</h5>
                        <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{money_format("%i",$pedido->valorTotal)}}</h3></p>
                    @endif
                </div>
            </div>
        </div>
        {{-- Valor Total do Pagamento --}}
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                    <h5 class="card-title">Valor Total do Pagamento</h5>
                    <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{money_format("%i",$valorTotalDoPagamento)}}</h3></p>
                </div>
            </div>
        </div>
    </div>
    {{-- FORMULÁRIO --}}
    <form id="formPagamento" action="{{route('pedido.pagamento')}}" method="POST">    
        @csrf

        <div class="row justify-content-center">
            
            {{-- Valor do desconto --}}
            <div class="col-sm-6">
                <div class="card cardFinalizarPedidos">
                    <div class="card-body">
                        <h5 class="card-title">Valor do Desconto nos Itens</h5>
                        <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDesconto">{{money_format("%i",$valorDoDesconto)}}</h3></p>                    
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="card cardFinalizarPedidos">
                    <div class="card-body">
                        {{-- <h5 class="card-title">Valor Pago</h5>
                        <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorTtalPago">0</h3></p> --}}
                        
                        {{-- Entregador --}}
                        <h5 class="card-title">Selecionar Entregador</h5>
                        <p class="card-text" style="margin-bottom: 10px">
                            <select name="entregador_id" class="form-control" id="entregador" required>
                                <option value="" selected disabled>-- Selecionar Entregador --</option>
                                @foreach ($entregadores as $entregador)
                                <option value="{{$entregador->id}}">{{$entregador->user->name}}</option>
                                @endforeach
                            </select>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- INFORMAÇÕES DO PAGAMENTO --}}
        

        

        {{-- Inputs contendo os descontos adicionados na tela de finalizar venda --}}
        
        {{-- ID do pedido --}}
        <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
        
        

        {{-- As Formas de pagamento dinâmicas são adicionadas aqui --}}
        <div id='divNovaFormaPagamento'></div>

        {{-- Botão Adicionar Forma de Pagamento --}}
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <button id="bntNovaFormaPagamento" class="btn btn-primary-ludke" style="margin:20px 0 20px 0">
                    <h3>Adicionar Forma de Pagamento</h3>
                </button>
            </div>
        </div>

        <div class="row justify-content-center" style="margin:30px 0 30px 0;">
            <div class="col-sm-6" style="heigth:100px">
                <a href="{{route('listarPedidos')}}" class="btn btn-secondary-ludke btn-pedido" >Voltar</a>
            </div>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary-ludke btn-pedido">Finalizar Pagamento</button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('javascript')

<script src="{{ asset('js/helper-pagamento.js') }}"></script>

<script type="text/javascript">

    const today = "<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d');?>";
    
    //Formas de pagamento
    let formasPagamento = <?php echo json_encode($formasPagamento); ?>; 
    

    $(function(){
        $('#formPagamento').submit(function(event){
            // Valor Total do pedido
            let valorTotal = <?= $valorTotalDoPagamento ?>
            // Contador para armazenar o valor adicionado em todas as formas de pagamento. 
            let contValorTotalPagamento = 0;

            // Mapeia todos os inputs do valor em cada forma de pagamento em um array
            let arrayValorTotalPagamento = $('input[name="valorTotalPagamento[]"').map(function(){
                return parseFloat(this.value);
            }).get();

            // Percore o array e soma todas as posições
            arrayValorTotalPagamento.forEach(valor => {
                contValorTotalPagamento += valor
            });

            if(!isValid()){
                // $("#formPagamento").submit();
                event.preventDefault();

                $("#divNovaFormaPagamento:not(:has(>div))").each(function(){
                    alert("Por favor, selecione uma forma de pagamento!");
                });
                }
                if(validPayment(contValorTotalPagamento, valorTotal) == false){
                    // impede o envio do form
                    event.preventDefault(); 
                    //alerta de erro
                    alert("O valor informado é menor do que o valor total! Uma nova forma de pagamento será adicionada.")

                    // Adiciona nova forma de pagamento ao formulário
                    var linhaForm = addFormaDePagamento(today);
                    $("#divNovaFormaPagamento").append(linhaForm);

                    // Adiciona o valor restante em na ultima forma de pagamento adicionada
                    $('input[name="valorTotalPagamento[]"').last().val(valorTotal - contValorTotalPagamento);
                }
                if(contValorTotalPagamento > valorTotal){
                    // impede o envio do form
                    event.preventDefault(); 
                    alert("O valor informado é maior do que o valor total! Verifique os valores informados.");
                }
        });

        // Ao clicar no botão "Adicionar Forma de Pagamento" Adiciona na tela os inputs da nova forma de pagamento
        $('#bntNovaFormaPagamento').click(function(){
            // alert('Adicionar Forma de pagamento')
            var linhaForm = addFormaDePagamento(today);
            $("#divNovaFormaPagamento").append(linhaForm);
        });

        
    });
    

    // Função que percorre os valores de entrada nos pagamentos e verifica se é maior que o valor do 
    //pedido.
    function validaValorPagamento(){
        // Valor Total do pedido
        let valorTotal = <?php echo $valorTotalDoPagamento; ?>
        // Contador para armazenar o valor adicionado em todas as formas de pagamento. 
        let contValorTotalPagamento = 0;

        // Mapeia todos os inputs do valor em cada forma de pagamento em um array
        let arrayValorTotalPagamento = $('input[name="valorTotalPagamento[]"').map(function(){
            return parseFloat(this.value);
        }).get();

        // Percore o array e soma todas as posições
        arrayValorTotalPagamento.forEach(valor => {
            contValorTotalPagamento += valor
        });

        if(contValorTotalPagamento > valorTotal){
            alert("O valor total informado no pagamento é maior do que o valor total do pedido! Por favor, informe novamente os valores.");
            $('input[name="valorTotalPagamento[]"').val('');
        }else{
            console.log(`Pagamento: ${contValorTotalPagamento} | Valor Total: ${valorTotal}`);

        }
    }
    
    // monta as linhas dos <option> com as formas de pagamento para serem exibidas no select
    function optionsFormaPagamento(){
        let options = "";
        formasPagamento.forEach(element => {
            options+= `<option value="${element.id}">${element.nome}</option>`;
        });
        return options;
    }
    function isValid(){
        let isValid = true;
        // if($('#dataVencimento').val() == ""){
        //     isValid = false;
        //     $("#spanDataVencimento").html("Selecione a Data de Vencimento")
        // }
        // if($('#dataVencimento').val() != ""){
        //     $("#spanDataVencimento").html("")
        // }
        // if($('#dataPagamento').val() == ""){
        //     isValid = false;
        //     $("#spanDataPagamento").html("Selecione a Data de Pagamento")
        // }
        // if($('#dataPagamento').val() != ""){
        //     $("#spanDataPagamento").html("")
        // }
        if($('#formaPagamento').val() == null){
            isValid = false;
            $("#spanformaPagamento").html("Selecione o Tipo de Pagamento")
        }
        if($('#formaPagamento').val() != null){
            $("#spanformaPagamento").html("")
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
    function calcularDesconto(valorTotal,valorDoDescontoNoPedido){
        let desconto = $('#descontoPagamento').val();
        if(desconto > 100){
            alert('Não é possível aplicar um desconto maior do que 100%');
            return null;
        }else{
            return (valorTotal * (desconto/100)) + valorDoDescontoNoPedido;

        }
    }

    // atualiza o valor do desconto ao inserir o desconto
    function atualizarValorDesconto(valorTotal,valorDoDescontoNoPedido){
        
        let valorDesconto = calcularDesconto(valorTotal,valorDoDescontoNoPedido);
        let inputDesconto = $('#descontoPagamento').val();

        if(valorDesconto != null){
            // valorDesconto = valorDesconto + valorDoDescontoNoPedido;
            // Atualiza na tela o valor do desconto
            $('#valorDesconto').html(valorDesconto);
        }else{
            $('#descontoPagamento').val(0);
            $('#valorDesconto').html(valorDoDescontoNoPedido);
        }
    }

    // atualizaValorParcialmentePago
    // atualiza o valor pago no pedido PARCIALMENTE PAGO
    function atualizaValorParcialmentePago(valorTotal, valorPagoPedido){
        let valorPago = $('#valorPago').val();
        
        if(valorPago > valorTotal ){
            alert(`Você não pode inserir um valor maior do que o valor do pedido: R$ ${valorTotal}`);
            $('#valorPago').val('');
            $('#valorTotalPago').html(valorPagoPedido);
        }else{
            $('#valorTotalPago').html(valorPago);
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