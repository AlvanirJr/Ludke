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
                    <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{$pedido->valorTotal}}</h3></p>
                @else
                    <h5 class="card-title">Valor Total do Pedido</h5>
                    <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{$pedido->valorTotal}}</h3></p>
                @endif
            </div>
        </div>
    </div>
    {{-- Valor Total do Pagamento --}}
    <div class="col-sm-6">
        <div class="card cardFinalizarPedidos">
            <div class="card-body">
                @if($pedido->status->status == "PAGO PARCIALMENTE" && isset($pagamento->valorTotalPagamento))
                    <h5 class="card-title">Valor Restante do Pagamento</h5>
                    <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{$valorRestantePagamento}}</h3></p>
                @else
                    <h5 class="card-title">Valor Total do Pagamento</h5>
                <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDoPedido">{{$valorTotalDoPagamento}}</h3></p>
                @endif
            </div>
        </div>
    </div>
</div>
    <div class="row justify-content-center">
        
        {{-- Valor do desconto --}}
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                    @if($pedido->status->status == "PAGO PARCIALMENTE")
                    <h5 class="card-title">Valor do Desconto no Pedido</h5>
                        <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDesconto">{{$valorDoDesconto}}</h3></p>
                    @else
                        <h5 class="card-title">Valor do Desconto</h5>
                        <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorDesconto">{{$valorDoDesconto}}</h3></p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card cardFinalizarPedidos">
                <div class="card-body">
                    
                    <h5 class="card-title">Valor Pago</h5>
                    <p class="card-text"><h3 style="float:left">R$</h3><h3 id="valorTotalPago">0</h3></p>
                
                </div>
            </div>
        </div>
    </div>


    {{-- INFORMAÇÕES DO PAGAMENTO --}}
    

    
    <form id="formPagamento" action="{{route('pedido.pagamento')}}" method="POST">    
        @csrf

        {{-- Inputs contendo os descontos adicionados na tela de finalizar venda --}}
        
        {{-- ID do pedido --}}
        <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
        {{-- 'funcionario_id' é o id do funcionario logado responsável pelo pagamento--}}
        <input type="hidden" name="funcionario_id" value="{{Auth::user()->funcionario->id}}">
        {{-- Entregador --}}
        <div class="row">
            <div class="col-sm-4 form-group">
                <label for="entregador_id">Entregador</label>
                <select name="entregador_id" class="form-control" id="entregador">
                    <option value="" selected disabled>-- Entregador --</option>
                    @foreach ($entregadores as $entregador)
                        <option value="{{$entregador->id}}">{{$entregador->user->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
<!--
        <div class="divNovaFormaPagamento">
            <div class="row justify-content-center">
                {{-- DataPagamento --}}
                <div class="col-sm-4 form-group">
                    <label for="dataPagamento">Data de Pagamento <span class="obrigatorio">*</span></label>
                    <input type="date" class="form-control" id="dataPagamento" name="dataPagamento">
                    <span style="color:red" id="spanDataPagamento"></span>
                </div>
                {{-- DataVencimento --}}
                <div class="col-sm-4 form-group">
                    <label for="dataVencimento">Data de Vencimento <span class="obrigatorio">*</span></label>
                    <input type="date" class="form-control" id="dataVencimento" name="dataVencimento">
                    <span style="color:red" id="spanDataVencimento"></span>
                </div>
    
                <div class="col-sm-4 form-group">
                    {{-- formaPagamento --}}
                    <label for="formaPagamento">Tipo de Pagamento <span class="obrigatorio">*</span></label>
                    <select name="formaPagamento" class="form-control" id="formaPagamento">
                        {{-- <option value="" disabled>-- Tipo de Pagamento --</option>
                        <option value="CARTÃO DE CRÉDITO" @if($pagamento->formaPagamento == "CARTÃO DE CRÉDITO") selected @endif>CARTÃO DE CRÉDITO</option>
                        <option value="BOLETO" @if($pagamento->formaPagamento == "BOLETO") selected @endif>BOLETO</option>
                        <option value="À VISTA" @if($pagamento->formaPagamento == "À VISTA") selected @endif>À VISTA</option>
                        <option value="À PRAZO" @if($pagamento->formaPagamento == "À PRAZO") selected @endif>À PRAZO</option> --}}
                    </select>
                    <span style="color:red" id="spanformaPagamento"></span>
                </div>
            </div>
        
            <div class="row justify-content-center">
                
                <div class="col-sm-4 form-group">
                    <label for="descontoPagamento">Desconto %</label>
                    <input id="descontoPagamento" type="number" class="form-control" value="">
                    <span style="color:red" id="spanDescontoPagamento"></span>
                </div>
                
                <div class="col-sm-4 form-group">
                    <label for="valorPago">Valor Pago (R$) <span class="obrigatorio">*</span></label>
                    <input type="number" id="valorPago" min="0" step="0.01" oninput="" class="form-control" name="valorPago">
                    <span style="color:red" id="spanValorPago"></span>
                </div>
    
                
                <div class="col-sm-4 form-group">
                    <label for="entregador_id">Entregador</label>
                    <select name="entregador_id" class="form-control" id="entregador">
                        <option value="" selected disabled>-- Entregador --</option>
                    </select>
                </div>
            </div>
                
            <div class="row justify-content-center">
                <div class="col-sm-12 form-group">
                    <label for="obs">Observações</label>
                    <textarea class="form-control" name="obs" id="" rows="5"></textarea>
                </div>
            </div>
        </div>

-->   
        
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

    let countFormaPagamento = 0;
    // Calcula o desconto dos itens
    function exibeDescontosItens(){
        let descontosItens = 0<?php //echo '["' . implode('", "', $descontos ?? '') . '"]' ?>;
        return descontosItens;
    }
    
    function montarForm(){
        
    }
    $(function(){
        $('#formPagamento').submit(function(event){
            if(!isValid()){
                event.preventDefault();
                // $("#formPagamento").submit();

                $("#divNovaFormaPagamento:not(:has(>div))").each(function(){
                    alert("Por favor, selecione uma forma de pagamento!");
                });
            }
            // console.log({
            //     dataVencimento: $('#dataVencimento').val(),
            //     dataPagamento: $('#dataPagamento').val(),
            //     formaPagamento: $('#formaPagamento').val(),
            //     valorPago: $('#valorPago').val(),
            //     descontoPagamento: $('#descontoPagamento').val()
            // })
        });

        // Ao clicar no botão "Adicionar Forma de Pagamento" Adiciona na tela os inputs da nova forma de pagamento
        $('#bntNovaFormaPagamento').click(function(){
            // alert('Adicionar Forma de pagamento')
            var linhaForm = addFormaDePagamento();
            $("#divNovaFormaPagamento").append(linhaForm);
        });

        console.log(exibeDescontosItens());
    });

    // Ao clicar no botão excluir, retira os inputs referente à forma de pagamento
    function excluirFormaPagamento(id){
        id = "formaPagamento"+id;
        $(`#${id}`).remove();
    }

    // Cria a linha com os inputs da nova forma de pagamento
    function addFormaDePagamento(){
        
        // console.log("Nova Forma de Pagamento")
        let form = "<div id='formaPagamento"+countFormaPagamento+"'>"+
                    "<div class='row informacoes'>"+
                        "<div class='col-sm-10'>"+
                            "<h3>Informações do Pagamento</h3>"+
                        "</div>"+
                        "<div class='col-sm-2'>"+
                            "<button class='btn btn-secondary-ludke' onclick='excluirFormaPagamento("+countFormaPagamento+")'>Excluir</button>"+
                        "</div>"+
                    "</div>"+
                    "<div class='row justify-content-center'>"+
                        "<div class='col-sm-6 form-group'>"+
                            "<label for='dataPagamento'>Data de Pagamento <span class='obrigatorio'>*</span></label>"+
                            "<input type='date' class='form-control' id='dataPagamento' name='dataPagamento[]' required>"+
                            "<span style='color:red' id='spanDataPagamento'></span>"+
                        "</div>"+
                        "<div class='col-sm-6 form-group'>"+
                            "<label for='dataVencimento'>Data de Vencimento <span class='obrigatorio'>*</span></label>"+
                            "<input type='date' class='form-control' id='dataVencimento' name='dataVencimento[]' required>"+
                            "<span style='color:red' id='spanDataVencimento'></span>"+
                        "</div>"+
                    "</div>"+
                    "<div class='row justify-content-center'>"+
                        "<div class='col-sm-4 form-group'>"+
                            "<label for='descontoPagamento'>Desconto %</label>"+
                            "<input id='descontoPagamento' type='number' class='form-control' value='0' name='descontoPagamento[]' required>"+
                            "<span style='color:red' id='spanDescontoPagamento'></span>"+
                        "</div>"+
                        "<div class='col-sm-4 form-group'>"+
                            "<label for='valorPago'>Valor Pago (R$) <span class='obrigatorio'>*</span></label>"+
                            "<input type='number' id='valorPago' min='0' step='0.01' oninput='' class='form-control' name='valorPago[]' required>"+
                            "<span style='color:red' id='spanValorPago'></span>"+
                        "</div>"+
                        "<div class='col-sm-4 form-group'>"+
                            "<label for='formaPagamento'>Tipo de Pagamento <span class='obrigatorio'>*</span></label>"+
                            "<select name='formaPagamento' class='form-control' id='formaPagamento' required>"+
                                "<option value='' disabled>-- Tipo de Pagamento --</option>"+
                                "<option value='CARTÃO DE CRÉDITO'>CARTÃO DE CRÉDITO</option>"+
                                "<option value='BOLETO'>BOLETO</option>"+
                                "<option value='À VISTA'>À VISTA</option>"+
                                "<option value='À PRAZO'>À PRAZO</option>"+
                            "</select>"+
                            "<span style='color:red' id='spanformaPagamento'></span>"+
                        "</div>"+
                    "</div>"+
                    "<div class='row justify-content-center'>"+
                        "<div class='col-sm-12 form-group'>"+
                            "<label for='obs'>Observações</label>"+
                            "<textarea class='form-control' name='obs' id='' rows='5'></textarea>"+
                        "</div>"+
                    "</div>"+
                "</div>";
        countFormaPagamento += 1;
        return form;           
    }
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