@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="titulo-pagina-nome">
                            <h2>Produtos</h2>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-primary-ludke" href="#" role="button">Novo</a>
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
                        <th>Produto 1</th>
                        <th>Categoria 1</th>
                        <th>06/06/2022</th>
                        <th>100</th>
                        <th>10,00</th>
                        <th>Produto que faz um monte de coisa bem legal</th>
                        <th>
                            <a href="#">Editar</a>
                            |
                            <a href="#">Excluir</a>
                        </th>
                    </tr>
                    <tr>
                        <th>Produto 2</th>
                        <th>Categoria 2</th>
                        <th>15/07/2022</th>
                        <th>100</th>
                        <th>10,00</th>
                        <th>Produto que faz um monte de coisa bem legal</th>
                        <th>
                            <a href="#">Editar</a>
                            |
                            <a href="#">Excluir</a>
                        </th>
                    </tr>
                    <tr>
                        <th>Produto 3</th>
                        <th>Categoria 2</th>
                        <th>10/10/2022</th>
                        <th>100</th>
                        <th>10,00</th>
                        <th>Produto que faz um monte de coisa bem legal</th>
                        <th>
                            <a href="#">Editar</a>
                            |
                            <a href="#">Excluir</a>
                        </th>
                    </tr>
                    
                </tbody>
            </table> <!-- end table -->
        </div><!-- end col-->
    </div><!-- end row-->
</div>

<div class="modal" tabindex="-1" role="dialog" id="dlgProdutos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formProduto">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Produto</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" class="form-control">
                    {{-- Nome do produto --}}
                    <div class="form-group">
                        <label for="nomeProduto" class="control-label">Nome do Produto</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nomeProduto" placeholder="Nome do Produto">
                        </div>
                    </div>

                    {{-- Categoria do produto --}}
                    <div class="form-group">
                        <label for="categoriaProduto" class="control-label">Categoria do Produto</label>
                        <div class="input-group">
                            <select class="form-control" id="categoriaProduto">

                            </select>
                        </div>
                    </div>

                    {{-- Validade do Produto --}}
                    <div class="form-group">
                        <label for="validadeProduto" class="control-label">Validade do Produto</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="validadeProduto" placeholder="Validade do Produto">
                        </div>
                    </div>

                    {{-- Quantidade do produto --}}
                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Quantidade do Produto</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="quantidadeProduto" placeholder="Quantidade do Produto">
                        </div>
                    </div>

                    {{-- Preço do produto --}}
                    <div class="form-group">
                        <label for="precoProduto" class="control-label">Preço do Produto</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="precoProduto" placeholder="Preço do Produto">
                        </div>
                    </div>

                    {{-- Descrição do produto --}}
                    <div class="form-group">
                        <label for="descricaoProduto" class="control-label">Descrição do Produto</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="descricaoProduto" placeholder="Descrição do Produto">
                        </div>
                    </div>
                </div><!-- end modal body-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Cadastrar</button>
                    <button type="cancel" class="btn btn-secondary" data-dissmiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- <script>

    // Usa a biblioteca quicksearch para buscar dados na tabela
    $('input#inputBusca').quicksearch('table#tabela tbody tr');

</script> --}}
@endsection