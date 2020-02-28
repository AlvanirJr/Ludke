@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="titulo-pagina-nome">
                            <h2>Pedidos</h2>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{route('pedidos')}}" class="btn btn-primary-ludke">Novo Pedido</a>
                    </div>
                    
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
<div class="modal fade" tabindex="-1" role="dialog" id="dlgPedidos">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formPedido" name="formPedido">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Pedido</h5>
                </div>
                <div class="modal-body">
                    {{-- ID da categoria --}}
                    <input type="hidden" id="id" class="form-control">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nomeCategoria" class="control-label">Cliente</label>
                            <h4 id="nomeCliente"></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nomeCategoria" class="control-label">Funcionário</label>
                            <h4 id="nomeFuncionario"></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nomeCategoria" class="control-label">Data de Entrega</label>
                            <div class="input-group">
                                <input id="inputDataEntrega" type="date" class="form-control">
                            </div>
                        </div>
                        
                    </div>

                    {{-- Nome do Categoria --}}
                    <div class="form-group">
                        {{-- Div para validação --}}
                        <label for="nomeCategoria" class="control-label">Itens</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <select class="form-control" id="itensPedido">
                                    
                                  </select>
                                
                            </div>
                        </div>
                        <div class="validationCategoria"></div>
                    </div>


                </div><!-- end modal body-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Cadastrar</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
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
        if(pedido.status != "FINALIZADO"){
            var linha = "<tr id="+pedido.id+">" +
                            "<td>"+pedido.id+"</td>"+
                            "<td>"+pedido.nomeCliente+"</td>"+
                            "<td>"+pedido.nomeFuncionario+"</td>"+
                            "<td>"+pedido.dataEntrega+"</td>"+
                            "<td><ul>"+retornaLinhaItensPedido(pedido.itens_pedidos)+"</h4></ul></td>"+
                            "<td>"+pedido.status+"</td>"+
                            "<td>R$ "+pedido.valorTotal+"</td>"+
                            "<td>"+
                                "<a href="+"/pedidos/concluir/"+pedido.id+">"+
                                    "<img id="+"iconeEdit"+" class="+"icone"+" src="+"{{asset('img/clipboard-check-solid.svg')}}"+" style="+"width:20px"+">"+
                                "</a>"+                            
                                "<a href="+"/pedidos/edit/"+pedido.id+">"+
                                    "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/edit-solid.svg')}}"+" style="+"width:25px;margin-right:15px"+">"+
                                "</a>"+
                                "<a href="+"#"+" onclick="+"excluirPedido("+pedido.id+")"+">"+
                                    "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/trash-alt-solid.svg')}}"+" style="+""+">"+
                                "</a>"+
                            "</td>"+
                        "</tr>";
            }else{
                var linha = "<tr id="+pedido.id+">" +
                            "<td>"+pedido.id+"</td>"+
                            "<td>"+pedido.nomeCliente+"</td>"+
                            "<td>"+pedido.nomeFuncionario+"</td>"+
                            "<td>"+pedido.dataEntrega+"</td>"+
                            "<td><ul>"+retornaLinhaItensPedido(pedido.itens_pedidos)+"</h4></ul></td>"+
                            "<td>"+pedido.status+"</td>"+
                            "<td>R$ "+pedido.valorTotal+"</td>"+
                            "<td>"+                          
                                "<a href="+"#"+" onclick="+"excluirPedido("+pedido.id+")"+">"+
                                    "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/trash-alt-solid.svg')}}"+" style="+""+">"+
                                "</a>"+
                            "</td>"+
                        "</tr>";
            }
        return linha;
        
    }

    function montarLinhaEditar(item){
        console.log(item)
        linha = "<option>"+item.nomeProduto+"</option>";
        return linha;
        console.log(item)
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
            linhaPedido += String("<li>NOME: "+itens_pedidos[i].nomeProduto+" | PESO SOLICITADO: "+itens_pedidos[i].pesoFinal+" KG</li>")
        }
        return linhaPedido;
        
    }
</script>

@endsection
