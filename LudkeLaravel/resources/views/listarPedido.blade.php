@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-sm-12">
                <div class="titulo-pagina">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="titulo-pagina-nome">
                                <h2>Pedidos</h2>
                            </div>
                        </div>
                        {{-- <div class="col-sm-2">
                            <a class="btn btn-primary-ludke" role="button" onclick="novoCargo()">Novo</a>
                        </div>
                        <div class="col-sm-3">
                            <input id="inputBusca" class="form-control input-ludke" type="text" placeholder="Pesquisar" name="pesquisar">
                        </div> --}}
                    </div>
                </div><!-- end titulo-pagina -->
            </div><!-- end col-->
        </div><!-- end row-->


        <div class="row justify-content-center">
            <div class="col-sm-12">
                <table id="tabelaPedidos" class="table table-hover table-responsive-sm">
                    <thead class="thead-primary">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Funcionário</th>
                        <th>Data da Entrega</th>
                        <th>Pedido</th>
                        <th>Status</th>
                        <th>Valor Total</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{-- Linhas da tabela serão adicionadas com javascript --}}
                    </tbody>
                </table> <!-- end table -->
            </div><!-- end col-->
        </div><!-- end row-->
    </div>



@endsection

@section('javascript')

<script type="text/javascript">
    $(function(){

        // Configuração do ajax com token csrf
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        start();
    });

    var timeI = null;
    var timeR = false;

    function stop(){
        if(timeR){
            clearTimeout(timerI);
        }
        timerR = false;
    }
    function start(){
        stop();
        carregarPedidos();

    }

    function limpaTabela(){
        $('#tabelaPedidos>tbody>tr').remove();
    }
    function carregarPedidos(){
        limpaTabela();
        $.getJSON('/getPedidos',function(pedidos){
            console.log(pedidos)
            for(var i=0; i < pedidos.length; i++){
                
                linha = montarLinha(pedidos[i]);
                $('#tabelaPedidos>tbody').append(linha);
            }

            timerI = setTimeout("carregarPedidos()", 60000);//tempo de espera
            timerR = true;
        });
    }
    function montarLinha(pedido){
        var linha = "<tr id="+pedido.id+">" +
                        "<td>"+pedido.id+"</td>"+
                        "<td>"+pedido.nomeCLiente+"</td>"+
                        "<td>"+pedido.nomeFuncionario+"</td>"+
                        "<td>"+pedido.dataEntrega+"</td>"+
                        "<td><ul>"+retornaLinhaItensPedido(pedido.itens_pedidos)+"</h4></ul></td>"+
                        "<td>"+pedido.status+"</td>"+
                        "<td>"+pedido.valorTotal+"</td>"+
                        "<td>"+
                            "<a href="+"#"+" onclick="+"concluirPedido("+pedido.id+")"+">"+
                                "<img id="+"iconeEdit"+" class="+"icone"+" src="+"{{asset('img/clipboard-check-solid.svg')}}"+" style="+"width:20px"+">"+
                            "</a>"+                            
                            "<a href="+"#"+" onclick="+"editarPedido("+pedido.id+")"+">"+
                                "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/edit-solid.svg')}}"+" style="+"width:25px;margin-right:15px"+">"+
                            "</a>"+
                            "<a href="+"#"+" onclick="+"excluirPedido("+pedido.id+")"+">"+
                                "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/trash-alt-solid.svg')}}"+" style="+""+">"+
                            "</a>"+
                        "</td>"+
                    "</tr>";
        return linha;
        
    }

    function concluirPedido(id){
        confirma = confirm("Você deseja fechar o pedido?");
        if(confirma){
            $.ajax({
                type:"POST",
                url: "/pedidos/concluir/"+id,
                context:this,
                success: function(data){
                    var pedido = JSON.parse(data);
                    console.log("Concluído");
                    linhas = $("#tabelaPedidos>tbody>tr");
                    e = linhas.filter(function(i,elemento){
                        if (elemento.cells[0].textContent == id){
                            elemento.cells[3].textContent = pedido.status;
                        }
                    });
                    
                }
            });
        }
    }

    function editarPedido(id){
        confirma = confirm("Você deseja cocluir o pedido?");
        if(confirma){
            console.log("Editar pedido "+ id);
        }
    }
    function excluirPedido(id){
        confirma = confirm("Você deseja excluir o pedido?");
        if(confirma){
            $.ajax({
                type:"DELETE",
                url: "/pedidos/excluir/"+id,
                context:this,
                success: function(){
                    console.log("deletou");
                    linhas = $("#tabelaPedidos>tbody>tr");
                    e = linhas.filter(function(i,elemento){
                        return elemento.cells[0].textContent == id;//faz um filtro na linha e retorna a que tiver o id igual ao informado

                    });
                    if(e){
                        e.remove();
                    }
                }
            });
        }
    }


    function retornaLinhaItensPedido(itens_pedidos){
        linhaPedido = "";
        for(var i = 0; i < itens_pedidos.length; i++){
            linhaPedido += String("<li>NOME: "+itens_pedidos[i].nomeProduto+" | PESO SOLICITADO: "+itens_pedidos[i].pesoSolicitado+" KG</li>")
        }
        return linhaPedido;
        
    }
</script>

@endsection
