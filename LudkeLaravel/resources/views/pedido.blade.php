@extends('layouts.app')

@section('content')

<div id="conteudo-pedidos" class="container-fluid">
    
    <div class="row justify-content-center">
        {{-- Coluna 1 --}}
        <div class="col-sm-6">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    {{-- Card Cliente --}}
                    <div id="cardCliente" class="card card-pedidos">
                        <div class="card-header">Cliente</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="hidden" id="cliente_id">
                                                <input id="buscaCliente" type="text" class="form-control" placeholder="Nome do Cliente">
                                                {{-- lista de produtos retornados da busca--}}
                                                <ul id="resultadoBuscaCliente" class="list-group"></ul>
                                            </div>
                                            
                                        </div>
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Nome</label>
                                    <h4 id="nomeCliente"></h4>
                                </div>
                            </div>
                        </div>
                        
                    </div>{{-- end Card Cliente --}}
                </div>
            </div>
            {{-- Row Produto --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    {{-- Card Produto --}}
                    <div id="cardProduto" class="card card-pedidos">
                        <div class="card-header">Produto</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input id="buscaProduto" type="text" class="form-control" placeholder="Nome do Produto">
                                                {{-- lista de produtos retornados da busca--}}
                                                <ul id="resultadoBuscaProduto" class="list-group"></ul>
                                            </div>
                                            <div class="col-sm-2">
                                                <input id="pesoProduto" step="0.01" type="number" class="form-control" placeholder="Peso">
                                            </div>
                                            <div class="col-sm-4">
                                                <a href="#" id="adicionarProduto" class="btn btn-primary-ludke">Adicionar</a>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                            </div>

                            {{-- informações do produto --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Nome</label>
                                            <input type="hidden" id="idProduto">
                                            <h4 id="nomeProduto"></h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="hidden" id="precoProduto">
                                            <label for="">Preço/Kg (R$)</label>
                                            <h4 id="textoPrecoProduto"></h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Preço Estimado (R$)</label>
                                            <h4 id="precoEstimado"></h4>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Descrição</label>
                                            <h5 id="descricaoProduto"></h5>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Categoria</label>
                                            <h5 id="categoriaProduto"></h5>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>{{-- informações do produto --}}
                        </div>
                    </div>{{-- end Card Produto --}}
                </div>
            </div>{{-- end Row Produto --}}

            <div class="row">
                <div class="col-sm-6">
                    <a href="" class="btn btn-secondary-ludke btn-pedido">Cancelar Pedido</a>
                </div>
                <div class="col-sm-6">
                    <a href="" class="btn btn-primary-ludke btn-pedido">Finalizar Pedido</a>
                </div>
            </div>

        </div>{{-- end Coluna 1 --}}

        {{-- Coluna 2 --}}

        <div class="col-sm-6">
            <div class="row justify-content-center">
                <div class="col-sm-12">

                    <div class="card card-pedidos">
                        <div class="card-header">Pedido</div>
                        <div id="listaPedidos" class="card-body">
                            <table id="tabelaPedidos" class="table table-responsive-lg table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>COD</th>
                                        <th>NOME</th>
                                        <th>PESO</th>
                                        <th>PREÇO/KG</th>
                                        <th>VALOR TOTAL</th>
                                        <th>AÇÕES</th>

                                    </tr>
                                </thead>
                                <tbody >
                                    {{-- VALORES DA TABELA SÃO DINAMICOS --}}
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>{{--  end lista produtos--}}
                
            </div>

            {{-- Row Informações Venda --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    {{-- Card Venda --}}
                    <div id="card-venda" class="card card-pedidos">
                        <div class="card-header">Venda</div>
                        <div class="card-body">
                            {{-- informações do produto --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row justify-content-between">
                                        <div class="col-sm-3">
                                            <label for="">Número de Itens</label>
                                            <h4 id="qtdItens"></h4>
                                            
                                            <label>Desconto</label>
                                            <div class="input-group">
                                                <input id="inputDesconto" step="0.01" type="number" class="form-control" placeholder="Desconto" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                              </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Subtotal</label>
                                            <h4 id="subtotal"></h4>

                                            <label for="">Valor Desconto</label>
                                            <h4 id="ValorDesconto"></h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Total</label>
                                            <p id="valorTotal" value=""></p>
                                        </div>
                                    </div>                                     
                                </div>
                            </div>{{-- informações do produto --}}
                        </div>
                    </div>{{-- end Card Venda --}}
                </div>
            </div>{{-- Row Informações Venda --}}
            
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(function(){
        // Configuração do ajax com token csrf
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Valor Total e num itens
        $("#valorTotal").html(0);
        $("#subtotal").html(0);
        $("#ValorDesconto").html(0);
        $("#qtdItens").html(0);

        // Busca de Cliente
        $("#buscaCliente").keyup(function(){
            var buscaCliente = $(this).val();
            if(buscaCliente.length >= 3){
                getCliente(buscaCliente);
            }else{
                $('#resultadoBuscaCliente').children().remove();
            }
        });

        // Clicar no link dos clientes
        $('body').on('click', "#resultadoBuscaCliente a", function(){
            idCliente = $(this).children().val(); //id do produto
            buscaCliente(idCliente);
        });

        // Busca do Produto
        $('#buscaProduto').keyup(function(){
            var buscaProduto = $(this).val();
            if(buscaProduto.length >= 3){
                getProdutos(buscaProduto);
            }
            if(buscaProduto.length == 0){
                limparCamposProduto();
            }
            else{
                $('#resultadoBuscaProduto').children().remove();
            }
        });

        // Clicar no link dos produtos
        $('body').on('click', "#resultadoBuscaProduto a", function(){
            idProduto = $(this).children().val(); //id do produto
            buscaProduto(idProduto);
        });

        // Digitar o valor do produto
        $('#pesoProduto').keyup(function(){
            $("#precoEstimado").html(calcularPrecoProduto($(this).val()));
        });

        // Adicionar Produto à lista
        $("#adicionarProduto").click(function(){
            adicionarProduto($("#idProduto").val());
        });

        //Digitar desconto
        $("#inputDesconto").keyup(function(){
            calcularDesconto();
            total = calcularTotal();
            $("#valorTotal").html(total);
            $("#valorTotal").val(total);
        });
    });

    function getCliente(nomeCliente){
        $.ajax({
            type: "POST",
            url: "/pedidos/getCliente",
            context: this,
            data: {nome: nomeCliente},
            success: function(data){
                cliente = JSON.parse(data)
                console.log(cliente);
                
                // limpa os links da lista com os produtos retornados em tempo real
                $('#resultadoBuscaCliente').children().remove();
                for(let i = 0; i < cliente.length; i++){

                    let linha = "<a "+"href="+"#"+">"+
                                    "<li value="+cliente[i].cliente.id+" class="+"list-group-item itemLista"+">"+cliente[i].name+"</li>"+
                                "</a>";
                    $('#resultadoBuscaCliente').append(linha);
                }
                // $('#cliente_id').val(cliente[0].id);
                // $('#nomeCliente').append(cliente[0].user.name);
                // console.log(cliente[0].user.name);
                
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function buscaCliente(id){
        $.ajax({
            url:'/api/clientes/'+id,
            method:"GET",
            success: function(data){
                cliente = JSON.parse(data);
                console.log(cliente);
                // $("#cliente_id").val(cliente.id);
                $("#nomeCliente").html(cliente.nome);
                $("#buscaCliente").val(cliente.nome);
                // limpa os links da lista com os produtos retornados em tempo real
                $('#resultadoBuscaCliente').children().remove();
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function getProdutos(buscaProduto){

        $.ajax({
            type: "POST",
            url: "/pedidos/getProdutos",
            data: {nome: buscaProduto},
            context: this,
            success: function(data){
                produtos = JSON.parse(data)
                console.log(produtos)

                // limpa os links da lista com os produtos retornados em tempo real
                $('#resultadoBuscaProduto').children().remove();
                for(let i = 0; i < produtos.length; i++){

                    let linha = "<a "+"href="+"#"+">"+
                                    "<li value="+produtos[i].id+" class="+"list-group-item itemLista"+">"+produtos[i].nome+"</li>"+
                                "</a>";
                    $('#resultadoBuscaProduto').append(linha);
                }
                
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    // Busca Produto selecionado no banco
    function buscaProduto(id){
        $.ajax({
            url:'/api/produtos/'+id,
            method:"GET",
            success: function(data){
                produto = JSON.parse(data);
                console.log(produto);
                console.log(produto.nome);
                console.log(produto.preco);
                $("#idProduto").val(produto.id);
                $("#nomeProduto").html(produto.nome);
                $("#buscaProduto").val(produto.nome);
                $("#textoPrecoProduto").html(produto.preco);
                $("#precoProduto").val(produto.preco);
                $("#descricaoProduto").html(produto.descricao);
                $("#categoriaProduto").html(produto.categoria.nome);

                // limpa os links da lista com os produtos retornados em tempo real
                $('#resultadoBuscaProduto').children().remove();
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function adicionarProduto(id){
        console.log(id);
        $.getJSON('/api/produtos/'+id,function(data){
            produto = data;
            peso = $("#pesoProduto").val();
            if(produto){
                if(peso && peso>0){
                    linha = montarLinha(produto,peso);
                    // Adiciona linha à tabela
                    $("#tabelaPedidos>tbody").append(linha);
                    // Atualiza o numero de itens
                    $("#qtdItens").html($("#tabelaPedidos>tbody>tr").length);
                    // Atualiza o valor total estimado do pedido
                    subtotal = calcularSubtotal();
                    $("#subtotal").html(subtotal);
                    desconto = calcularDesconto();
                    console.log(desconto);
                    $("#ValorDesconto").html(desconto);

                    total = calcularTotal();
                    $("#valorTotal").html(total);
                    $("#valorTotal").val(total);


                    // console.log()
                    limparCamposProduto();

                }else{
                    alert("Digite o peso do produto!");
                }
            }
        });
    }
    function montarLinha(produto,peso){
        linha = "<tr>"+
                    "<td>"+produto.id+"</td>"+
                    "<td>"+produto.nome+"</td>"+
                    "<td>"+peso+"</td>"+
                    "<td>"+produto.preco+"</td>"+
                    "<td class="+"precoCalculado"+">"+calcularPrecoProduto(peso)+"</td>"+
                    "<td>Ações</td>"+
                "</tr>";
        return linha;
    }

    function limparCamposProduto(){

        $("#idProduto").val('');
        $("#buscaProduto").val('');
        $("#pesoProduto").val('');

        $("#nomeProduto").html('');
        $("#textoPrecoProduto").html('');
        $("#precoEstimado").html('');
        $("#descricaoProduto").html('');
        $("#categoriaProduto").html('');
    }
    function calcularSubtotal(){
        let precoCalculado = parseFloat(0);
        $(".precoCalculado").each(function(){
            console.log($(this).text());
            precoCalculado += parseFloat($(this).text());
        });
        console.log(precoCalculado);
        return precoCalculado;
    }
    function calcularDesconto(){
        desconto = $("#inputDesconto").val()
        
        subtotal = calcularSubtotal();
        console.log('Subtotal: ',subtotal);

        resultado = (subtotal * (desconto/100)).toPrecision();
        
        console.log('Total Desconto', resultado);
        $("#ValorDesconto").html(resultado);
        
        return resultado;
    }
    function calcularTotal(){
        subtotal = calcularSubtotal();
        desconto = calcularDesconto();

        resultado = subtotal - desconto;
        return resultado;
    }
    function calcularPrecoProduto(peso){
        if(peso>0){
            preco = $("#precoProduto").val();
            resultado = preco * peso;
            return resultado;
        }
        
    }
</script>
@endsection