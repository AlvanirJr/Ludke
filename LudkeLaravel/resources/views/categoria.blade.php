@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="titulo-pagina-nome">
                            <h2>Categorias</h2>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-primary-ludke" href="#" role="button" onclick="novoCategoria()">Novo</a>
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
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                    
                    <tr>
                        <th>1</th>
                        <th>Categoria 1</th>
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
                        <th>Categoria 2</th>
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
                        <th>Categoria 3</th>
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
            <form class="form-horizontal" id="formProduto">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Produto</h5>
                </div>
                <div class="modal-body">
                    {{-- ID da categoria --}}
                    <input type="hidden" id="id" class="form-control">

                    {{-- Nome do Categoria --}}
                    <div class="form-group">
                        <label for="nomeCategoria" class="control-label">Nome da Categoria</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nomeCategoria" placeholder="Nome da Categoria">
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

    function novoCategoria(){
        // Limpa campos do modal
        $('#id').val('');
        $('#nomeCategoria').val('');
        
        // exibe modal cadastrar Produtos
        $('#dlgProdutos').modal('show');
    }
</script>
    
@endsection