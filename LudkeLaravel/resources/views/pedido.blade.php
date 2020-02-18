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
                                                <input id="buscaCliente" type="text" class="form-control" placeholder="Nome do Cliente" autofocus>
                                                {{-- lista de clientes retornados da busca--}}
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
                    <a href="#" class="btn btn-secondary-ludke btn-pedido">Cancelar Pedido</a>
                </div>
                <div class="col-sm-6">
                    <a href="#" id="btnFinalizarPedido" class="btn btn-primary-ludke btn-pedido">Finalizar Pedido</a>
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
                                        <div class="col-sm-4">
                                            <label for="">Número de Itens</label>
                                            <h4 id="qtdItens"></h4>
                                            
                                            <label>Desconto</label>
                                            <div class="input-group">
                                                <input id="inputDesconto" step="0.01" value=0 type="number" class="form-control" placeholder="Desconto">
                                                <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                              </div>

                                              <label>Data de Entrega</label>
                                            <div class="input-group">
                                                <input id="inputDataEntrega" type="date" class="form-control">
                                                
                                              </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Subtotal</label>
                                            <h4 id="subtotal"></h4>

                                            <label for="">Valor Desconto</label>
                                            <h4 id="ValorDesconto"></h4>
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="">Total</label>
                                            <h1 id="valorTotal" value=""></h1>
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
    
    // Objeto contendo as informações do pedido 
    var pedido = {
        listaProdutos : [],
    }

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
            if($(this).val() >= 0){
                $("#precoEstimado").html(calcularPrecoProduto($(this).val()));
            }else{
                alert("Esse peso não pode ser calculado");
                $(this).val(0);
                return;
            }
        });

        // Adicionar Produto à lista
        $("#adicionarProduto").click(function(){
            if($("#idProduto").val()){
                adicionarProduto($("#idProduto").val());
            }else{
                alert("Erro ao adicionar Produto");
                return;
            }
        });

        //Digitar desconto
        $("#inputDesconto").keyup(function(){
            calcularDesconto();
            total = calcularTotal();
            $("#valorTotal").html(total);
            $("#valorTotal").val(total);
        });
        // Finalizar Pedido
        $("#btnFinalizarPedido").click(function(){
            confirma = confirm("Você deseja finalizar o pedido?");
            if(confirma){      
                montarPedido();
            }
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
                // console.log(cliente);
                
                // limpa os links da lista com os produtos retornados em tempo real
                $('#resultadoBuscaCliente').children().remove();
                for(let i = 0; i < cliente.length; i++){

                    let linha = "<a "+"href="+"#"+">"+
                                    "<li value="+cliente[i].cliente.id+" class="+"list-group-item itemLista"+">"+cliente[i].name+"</li>"+
                                "</a>";
                    $('#resultadoBuscaCliente').append(linha);
                }
                
                // console.log("getCliente()",pedido);
                // $('#cliente_id').val(cliente[0].id);
                
                
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
                // Adiciona ao objeto Pedido o id do cliente
                pedido.cliente_id = cliente.id;
                $("#nomeCliente").html(cliente.nome);
                $("#buscaCliente").val(cliente.nome);
                console.log("buscaCliente()",pedido)
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
                // console.log(produtos)

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
                // console.log(produto);
                // console.log(produto.nome);
                // console.log(produto.preco);
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

    // calcula o valor total do item adicionado a lista de pedidos
    function calcularTotalItem(valorProduto, peso){
        return valorProduto*peso;
    }
    function adicionarProduto(id){
        
        peso = parseFloat($("#pesoProduto").val());
        if(peso && peso>0){
            $.getJSON('/api/produtos/'+id,function(data){
                produto = data;
                // console.log("adicionarProduto()",produto)
                if(produto){
                        // Adiciona as informações do produto à lista de pedidos
                        let itemPedido  = [];
                        itemPedido.push({
                            produto_id: produto.id, 
                            peso:peso, 
                            valorTotalItem: calcularTotalItem(produto.preco,peso)
                            });
                        pedido.listaProdutos.push(itemPedido);
                        console.log("adicionarProduto()",pedido)
                        
                        
                        // Adiciona linha à tabela
                        linha = montarLinha(produto,peso);
                        $("#tabelaPedidos>tbody").append(linha);

                        // Atualiza o numero de itens
                        $("#qtdItens").html(pedido.listaProdutos.length);
                        
                        
                        // Atualiza o valor total estimado do pedido
                        subtotal = calcularSubtotal();
                        $("#subtotal").html(subtotal);

                        // Calcula o desconto
                        desconto = calcularDesconto();
                        $("#ValorDesconto").html(desconto);
                        
                        // Calcula o total
                        total = calcularTotal();
                        pedido.total = total;
                        console.log(pedido);
                        $("#valorTotal").html(total);
                        $("#valorTotal").val(total);


                        // console.log()
                        limparCamposProduto();

                }
            });
        }else{
            alert("Digite o peso do produto!");
        }
    }
    function montarLinha(produto,peso){
        linha = "<tr>"+
                    "<td value="+produto.id+">"+produto.id+"</td>"+
                    "<td>"+produto.nome+"</td>"+
                    "<td value="+peso+">"+peso+"</td>"+
                    "<td>"+produto.preco+"</td>"+
                    "<td value="+calcularTotalItem(produto.preco,peso)+" class="+"precoCalculado"+">"+calcularTotalItem(produto.preco,peso)+"</td>"+
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
        // percorre a lista de produtos calculando o subtotal
        var subtotal = 0;
        var listaProdutos = pedido.listaProdutos;
        for(i = 0; i < listaProdutos.length; i++){
            subtotal += listaProdutos[i][0].valorTotalItem;
        }
        return subtotal;
        
    }
    function calcularDesconto(){
        // valor do desconto
        let desconto = 0;
        desconto = $("#inputDesconto").val()
        
        console.log("calcularDesconto()",desconto)
        
        subtotal = calcularSubtotal();

        resultado = (subtotal * (desconto/100)).toPrecision();
        
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
    function limparTela(){
        $("#cliente_id").val(0);
        $('#nomeCliente').html("");
        $("#buscaCliente").val("");
        $("#qtdItens").html("");
        $("#inputDesconto").val(0);
        $("#inputDataEntrega").val('');
        $("#valorTotal").html(0);
        $("#subtotal").html(0);
        $("#ValorDesconto").html(0);
        $("#qtdItens").html(0);
        $("#valorTotal").val(0);

        pedido = {
            listaProdutos : [],
        }

        limparCamposProduto();
        $("#tabelaPedidos>tbody").html('');
    }
    function montarPedido(){
        
        
        pedido.desconto = parseFloat($("#inputDesconto").val());

        pedido.valorDesconto = parseFloat(calcularDesconto());
        pedido.dataEntrega = $("#inputDataEntrega").val();
        
        console.log("montarPedido()",pedido)


        
        if(!pedido.cliente_id){
            alert("Selecione o cliente para concluir o pedido!");
            return;
        }
        if(pedido.listaProdutos.length == 0 && pedido.total == 0){
            alert("Selecione um ou mais produtos para concluir o pedido!");
            return;
        }
        if(pedido.dataEntrega.length == 0){
            alert("Selecione uma data de entrega para concluir o pedido!");
            return;
        }
        else{
            
            console.log(pedido)
            $.ajax({
                url: '/pedidos/finalizar',
                method: "POST",
                data: pedido,
                context: this,
                success: function(data){
                    msg = JSON.parse(data);
                    if(msg.success == true){
                        limparTela();
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
    }
</script>
@endsection