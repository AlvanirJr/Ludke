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
                        <a href="{{route('pedidos')}}" class="btn btn-primary-ludke">Novo Pedido</a>
                    </div>
                    
                </div>
            </div><!-- end titulo-pagina -->
        </div><!-- end col-->
    </div><!-- end row-->

    <form action="" method="POST">
        @csrf
        <div class="form-group row">
            <div class="col-sm-2">
                <input type="text" class="form-control" name="cliente" placeholder="Nome do Cliente">
            </div>
            <div class="col-sm-2">
                <input type="date" class="form-control" name="cliente" placeholder="Nome do Cliente">
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="status" id="">
                    <option value="" disabled selected>-- STATUS --</option>
                    <option value="ABERTO">ABERTO</option>
                    <option value="FINALIZADO">FINALIZADO</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="cidade" placeholder="Cidade">
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="bairro" placeholder="Bairro">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary-ludke">FILTRAR</button>
            </div>
        </div>
    </form>
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
                                <td>{{$pedido->created_at}}</td>
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
                                <td>{{$pedido->created_at}}</td>
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
        {{ $pedidos->render() }}
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
