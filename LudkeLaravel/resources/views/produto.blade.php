@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="titulo-pagina-nome">
                            <h2>Produtos</h2>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-primary-ludke" role="button" onclick="novoProduto()">Novo</a>
                    </div>
                    <div class="col-sm-3"> 
                        <input id="inputBusca" class="form-control input-ludke" type="text" placeholder="Pesquisar" name="pesquisar">
                    </div>
                </div>
            </div><!-- end titulo-pagina -->
        </div><!-- end col-->
    </div><!-- end row-->


    <div class="row justify-content-center">
        <div class="col-sm-12">
            <table id="tabela" class="table table-hover table-responsive-sm">
                <thead class="thead-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Validade</th>
                        <th>Quantidade</th>
                        <th>Preço(R$)</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                    
                    <tr>
                        <th>1</th>
                        <th>Produto 1</th>
                        <th>Categoria 1</th>
                        <th>06/06/2022</th>
                        <th>100</th>
                        <th>10,00</th>
                        <th>Produto que faz um monte de coisa bem legal</th>
                        <th>
                            <a href="#">
                                <img id="iconeEdit" class="icone" src="{{asset('img/edit-solid.svg')}}" style="width:25px; margin-right:20px;">
                            </a>
                            
                            <a href="#">
                                <img id="iconeDelete" class="icone" src="{{asset('img/trash-alt-solid.svg')}}" style="width:20px">
                            </a>
                        </th>
                    </tr>
                    <tr>
                        <th>2</th>
                        <th>Produto 2</th>
                        <th>Categoria 2</th>
                        <th>15/07/2022</th>
                        <th>100</th>
                        <th>10,00</th>
                        <th>Produto que faz um monte de coisa bem legal</th>
                        <th>
                            <a href="#">
                                <img id="iconeEdit" class="icone" src="{{asset('img/edit-solid.svg')}}" style="width:25px; margin-right:20px;">
                            </a>
                            
                            <a href="#">
                                <img id="iconeDelete" class="icone" src="{{asset('img/trash-alt-solid.svg')}}" style="width:20px">
                            </a>
                        </th>
                    </tr>
                    <tr>
                        <th>3</th>
                        <th>Produto 3</th>
                        <th>Categoria 2</th>
                        <th>10/10/2022</th>
                        <th>100</th>
                        <th>10,00</th>
                        <th>Produto que faz um monte de coisa bem legal</th>
                        <th>
                            <a href="#">
                                <img id="iconeEdit" class="icone" src="{{asset('img/edit-solid.svg')}}" style="width:25px; margin-right:20px;">
                            </a>
                            
                            <a href="#">
                                <img id="iconeDelete" class="icone" src="{{asset('img/trash-alt-solid.svg')}}" style="width:20px">
                            </a>
                        </th>
                    </tr>
                    
                </tbody>
            </table> <!-- end table -->
        </div><!-- end col-->
    </div><!-- end row-->
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="dlgProdutos">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formProduto" method="POST" href="{{ route('produto.store')}}" data-route="{{ route('produto.store')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Novo Produto</h5>
                </div>
                <div class="modal-body">
                    
                    {{-- ID do produto --}}
                    <input type="hidden" id="id" class="form-control">

                    {{-- Nome do produto --}}
                    <div class="form-group">
                        <label for="nomeProduto" class="control-label">Nome do Produto</label>
                        <div class="input-group">
                            <input type="text" name="nome" class="form-control" id="nomeProduto" placeholder="Nome do Produto">
                        </div>
                    </div>

                    {{-- Categoria do produto --}}
                    <div class="form-group">
                        <label for="categoriaProduto" class="control-label">Categoria do Produto</label>
                        <div class="input-group">
                            <select name="categoria_id" class="form-control" id="categoriaProduto">
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>

                    {{-- Validade do Produto --}}
                    <div class="form-group">
                        <label for="validadeProduto" class="control-label">Validade do Produto</label>
                        <div class="input-group">
                            <input type="date" name="validade" class="form-control" id="validadeProduto" placeholder="Validade do Produto">
                        </div>
                    </div>

                    {{-- Quantidade do produto --}}
                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Quantidade do Produto</label>
                        <div class="input-group">
                            <input type="number" name="quantidade" class="form-control" id="quantidadeProduto" placeholder="Quantidade do Produto">
                        </div>
                    </div>

                    {{-- Preço do produto --}}
                    <div class="form-group">
                        <label for="precoProduto" class="control-label">Preço do Produto</label>
                        <div class="input-group">
                            <input type="number" name="preco" class="form-control" id="precoProduto" placeholder="Preço do Produto">
                        </div>
                    </div>

                    {{-- Descrição do produto --}}
                    <div class="form-group">
                        <label for="descricaoProduto" class="control-label">Descrição do Produto</label>
                        <div class="input-group">
                            <textarea class="form-control" name="descricao" id="descricaoProduto" placeholder="Descrição do Produto"></textarea>
                            {{-- <input type="text" class="form-control" id="descricaoProduto" placeholder="Descrição do Produto"> --}}
                        </div>
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

    // Usa a biblioteca quicksearch para buscar dados na tabela
    // $('input#inputBusca').quicksearch('table#tabela tbody tr');

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // $(function(){
    //     $('#formProduto').submit(function(event){
    //         var route = $('#formProduto').data('route');
            
    //         event.preventDefault();
    //         $.ajax({
    //             type: 'POST',
    //             url: route,
    //             data: $(this).serialize(),
    //             success: function (Response) {
    //             console.log(Response);
    //             },
    //             error: function (Response, textStatus, errorThrown) {
    //                 console.log(Response);

    //             },
    //         });
    //     });
    // });

    // function criarProduto(){
    //     var route = $('#formProduto').data('route');
    //     console.log(route);
    //     prod = {
    //         nome: $("#nomeProduto").val(),
    //         categoria_id: $("#categoriaProduto").val(),
    //         validade: $("#validadeProduto").val(),
    //         quantidade: $("#quantidadeProduto").val(),
    //         preco: $("#precoProduto").val(),
    //         descricao: $("#descricaoProduto").val()
    //     };
    //     console.log(prod);
    //     $.post(route,prod,function(data){
    //         console.log(data);
    //     });
        
    // }
    // $(function(){
    //     $('#formProduto').submit(function(event){
    //         event.preventDefault();
    //         criarProduto();
    //         $('#dlgProdutos').modal('hide');
            
    //     });
    // });

    function novoProduto(){
        // Limpa campos do modal
        $('#id').val('');
        $('#nomeProduto').val('');
        $('#categoriaProduto').val('');
        $('#validadeProduto').val('');
        $('#quantidadeProduto').val('');
        $('#precoProduto').val('');
        $('#descricaoProduto').val('');
        // exibe modal cadastrar Produtos
        $('#dlgProdutos').modal('show');
    }
</script>
    
@endsection