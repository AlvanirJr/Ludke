@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row d-flex justify-content-between">
                    <div class="col-sm-7">
                        <div class="titulo-pagina-nome">
                            <h2>Vendas</h2>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        {{-- <a href="#" data-toggle="modal" data-target="#dlgFiltro"class="btn btn-primary-ludke">Filtrar</a> --}}
                        <button id="btnFiltrar" type="button" class="btn btn-primary-ludke" data-toggle="modal" data-target="#modalFiltro">
                            Filtrar
                          </button>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{route('vendas')}}" class="btn btn-primary-ludke">Nova Venda</a>
                    </div>
                    
                </div>
            </div><!-- end titulo-pagina -->
        </div><!-- end col-->
    </div><!-- end row-->
    
    {{-- Caso uma venda seja realizada, o statusVenda é setado como success e uma
    mensagem é exibida para o usuário informando que a venda foi realizada --}}
    @if (isset($statusVenda))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Venda Realizada com sucesso!</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Caso não consiga finalizar pagamento, exibe mensagem de erro --}}
    @if(isset($erroPagamento))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro: {{$erroPagamento}} </a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Caso o pagamento for feito con sucesso, exibe mensagem de sucesso --}}
    @if(isset($sucessoPagamento))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso: {{$sucessoPagamento}} </a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    {{-- Variável acho é setada caso encontre algum item no filtro --}}
    @if(isset($achou) && $achou == true)
    <div class="row">
        <div class="col-sm-12 limparBusca">
            <a href="{{route('listarVendas')}}">
                <button class="btn btn-outline-danger">Listar Todos</button>
            </a>

        </div>
    </div>
    @endif
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
                    @foreach ($pedidos as $pedido)
                    <tr id="{{$pedido->id}}">
                        <td>{{$pedido->id}}</td>
                        <td>{{$pedido->cliente->user->name}}</td>
                        <td>{{$pedido->funcionario->user->name}}</td>
                        <td>{{date('d/m/Y',strtotime($pedido->dataEntrega))}}</td>
                        <td>
                            <ul>
                                @foreach ($pedido->itensPedidos as $itens)
                                <li>{{$itens->nomeProduto}} | {{$itens->pesoSolicitado}} KG</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$pedido->status->status}}</td>
                        <td>R$ {{$pedido->valorTotal}}</td>
                        {{-- Verifica se o status do pedido é SOLICITADO --}}
                        @if($pedido->status->status == "ENTREGUE")
                        
                        <td>
                            {{-- Contas a pagar --}}
                            <a href="#" onclick="alert('A funcionalidade de CONTAS A RECEBER está sendo desenvolvida. Logo estará disponível para utilização!')">
                                <img id="pagar" class="icone" src="{{asset('img/money-bill-wave-solid.svg')}}" >
                            </a> 
                            {{-- Excluir Pedido --}}
                            <a href="#" onclick="excluirPedido({{$pedido->id}})">
                                <img id="deletar" class="icone" src="{{asset('img/trash-alt-solid.svg')}}" >
                            </a>
                        </td>
                        {{-- Verifica se o status do pedido é PESADO --}}
                        @elseif($pedido->status->status == "PESADO")
                            <td>
                                <a href="{{route('concluirVenda',['id'=>$pedido->id])}}">
                                    <img class="icone" src="{{asset('img/cash-register-solid-black.svg')}}" style="width:20px">
                                </a>                            

                                <a href="#" onclick="excluirPedido({{$pedido->id}})">
                                    <img id="iconeDelete" class="icone" src="{{asset('img/trash-alt-solid.svg')}}">
                                </a>
                            </td>
                        
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table> <!-- end table -->
        </div><!-- end col-->
    </div><!-- end row-->

    <div class="row justify-content-center">
        @if ($pedidos != [])
            @if (isset($filtro))
            {{ $pedidos->appends($filtro)->links() }}
            
            @else
            {{ $pedidos->links() }}
            @endif
        @endif
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="modalFiltro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filtrar Pedido</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('vendas.filtrar')}}" method="POST">
            @csrf
            <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="cliente">Nome do Cliente</label>
                            <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Nome do Cliente">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="dataEntrega">Data de Entrega</label>
                            <input type="date" class="form-control" id="dataEntrega" name="dataEntrega">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="status">Status</label>
                            <select class="form-control" name="status_id" id="status_id">
                                <option value="" disabled selected>-- STATUS --</option>
                                <option value="1">SOLICITADO</option>
                                <option value="2">PESADO</option>
                                <option value="4">PAGO PARCIALMENTE</option>
                                <option value="5">PAGO TOTALMENTE</option>
                                <option value="3">ENTREGUE</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Filtrar</button>
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

        // cliente
        // dataEntrega
        // status
        $('#btnFiltrar').click(function(){
            $('#cliente').val('');
            $('#dataEntrega').val('');
            $('#status').val('');
        });
    });

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

</script>

@endsection
