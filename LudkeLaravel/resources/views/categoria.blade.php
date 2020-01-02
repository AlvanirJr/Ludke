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
                        <a class="btn btn-primary-ludke" role="button" onclick="novaCategoria()">Novo</a>
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
            <table id="tabelaCategorias" class="table table-hover table-responsive-sm">
                <thead class="thead-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="dlgCategorias">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formProduto" name="formCategoria">
                <div class="modal-header">
                    <h5 class="modal-title">Nova Categoria</h5>
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

    
    $(function(){
        // Configuração do ajax com token csrf
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        carregarCategorias();
    });

    //function novaCategoria(){
    function novaCategoria(){
        $('#id').val('');
        $('#nomeCategoria').val('');

        // exibe o modal cadastrar categorias
        $('#dlgCategorias').modal('show');
    }

    function montarLinha(p){
        //cria um html da linha da tabela
        var linha = "<tr>" +
                        "<td>"+p.id+"</td>"+
                        "<td>"+p.nome+"</td>"+
                        "<td>"+
                            "<a href="+"#"+" onclick="+"editarProduto("+p.id+")"+">"+
                                "<img id="+"iconeEdit"+" class="+"icone"+" src="+"{{asset('img/edit-solid.svg')}}"+" style="+""+">"+
                            "</a>"+                            
                            "<a href="+"#"+" onclick="+"removerProduto("+p.id+")"+">"+
                                "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/trash-alt-solid.svg')}}"+" style="+""+">"+
                            "</a>"+
                        "</td>"+
                    "</tr>";
        return linha;
    }

    function carregarCategorias(){
        $.getJSON('/api/categorias', function(categorias){
            console.log('ok');
            for(i=0; i < categorias.length;i++){
                linha = montarLinha(categorias[i]);
                $('#tabelaCategorias>tbody').append(linha);
            }
        });
    }

   $(function () {
       $('form[name="formCategoria"]').submit(function (event) {
           event.preventDefault();
        //    alert("teste");

       })

    });



  </script>

@endsection
