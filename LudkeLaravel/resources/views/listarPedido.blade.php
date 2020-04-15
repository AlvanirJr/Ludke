@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row d-flex justify-content-between">
                    <div class="col-sm-7">
                        <div class="titulo-pagina-nome">
                            <h2>Pedidos</h2>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        {{-- <a href="#" data-toggle="modal" data-target="#dlgFiltro"class="btn btn-primary-ludke">Filtrar</a> --}}
                        <button type="button" class="btn btn-primary-ludke" data-toggle="modal" data-target="#exampleModal">
                            Filtrar
                          </button>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{route('pedidos')}}" class="btn btn-primary-ludke">Novo Pedido</a>
                    </div>
                    
                </div>
            </div><!-- end titulo-pagina -->
        </div><!-- end col-->
    </div><!-- end row-->

    @if(isset($achou) && $achou == true)
    <div class="row">
        <div class="col-sm-12 limparBusca">
            <a href="{{route('listarPedidos')}}">
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
                        @if($pedido->status != "FINALIZADO")
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
                                <td>{{$pedido->status}}</td>
                                <td>R$ {{$pedido->valorTotal}}</td>
                                <td>
                                    <a href="/pedidos/concluir/{{$pedido->id}}">
                                        <img id="iconeEdit" class="icone" src="{{asset('img/clipboard-check-solid.svg')}}" style="width:20px">
                                    </a>                            
                                    <a href="/pedidos/edit/{{$pedido->id}}">
                                        <img id="iconeDelete" class="icone" src="{{asset('img/edit-solid.svg')}}" style="width:25px;margin-right:15px">
                                    </a>

                                    <a href="#" onclick="excluirPedido({{$pedido->id}})">
                                        <img id="iconeDelete" class="icone" src="{{asset('img/trash-alt-solid.svg')}}">
                                    </a>
                                </td>
                            </tr>
                        @else
                            <tr id="{{$pedido->id}}">
                                <td>{{$pedido->id}}</td>
                                <td>{{$pedido->cliente->user->name}}</td>
                                <td>{{$pedido->funcionario->user->name}}</td>
                                <td>{{date('d/m/Y',strtotime($pedido->dataEntrega))}}</td>
                                <td>
                                    <ul>
                                        @foreach ($pedido->itensPedidos as $itens)
                                            <li>{{$itens->nomeProduto}} | {{$itens->pesoFinal}} KG</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{$pedido->status}}</td>
                                <td>R$ {{$pedido->valorTotal}}</td>
                                <td>
                                    {{-- <a href="/pedidos/concluir/{{$pedido->id}}">
                                        <img id="iconeEdit" class="icone" src="{{asset('img/clipboard-check-solid.svg')}}" style="width:20px">
                                    </a>                             --}}
                                    {{-- <a href="/pedidos/edit/{{$pedido->id}}">
                                        <img id="iconeDelete" class="icone" src="{{asset('img/edit-solid.svg')}}" style="width:25px;margin-right:15px">
                                    </a> --}}

                                    <a href="#" onclick="excluirPedido({{$pedido->id}})">
                                        <img id="iconeDelete" class="icone" src="{{asset('img/trash-alt-solid.svg')}}">
                                    </a>
                                </td>
                            </tr>

                        @endif
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filtrar Pedido</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('pedido.filtrar')}}" method="POST">
            @csrf
            <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="cliente">Nome do Cliente</label>
                            <input type="text" class="form-control" name="cliente" placeholder="Nome do Cliente">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="dataEntrega">Data de Entrega</label>
                            <input type="date" class="form-control" name="dataEntrega">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="">
                                <option value="" disabled selected>-- STATUS --</option>
                                <option value="ABERTO">ABERTO</option>
                                <option value="FINALIZADO">FINALIZADO</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" name="cidade" placeholder="Cidade">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control" name="bairro" placeholder="Bairro">
                        </div>
                    </div> --}}

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

        start();
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
