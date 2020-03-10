@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">

            <div class="col-sm-12">
                <div class="titulo-pagina">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="titulo-pagina-nome">
                                <h2>Cargos</h2>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-primary-ludke" role="button" onclick="novoCargo()">Novo</a>
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
                <table id="tabelaCargos" class="table table-hover table-responsive-sm">
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

    <div class="modal fade" tabindex="-1" role="dialog" id="dlgCargos">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formCargo" name="formCargo">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Cargo </h5>
                    </div>
                    <div class="modal-body">
                        {{-- ID da cargo --}}
                        <input type="hidden" id="id" class="form-control">

                        {{-- Nome do Cargo --}}
                        <div class="form-group">
                            <label for="nomeCargo" class="control-label">Nome do Cargo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nomeCargo" placeholder="Nome do Cargo" autofocus>
                            </div>
                            <div class="validationCargo"></div>
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
        // $('input#inputBusca').quicksearch('table#tabelaCategorias tbody tr');
        var token = <?php json_encode(Auth::user()->api_token); ?>
        console.log(token);
        $(function(){

            // Configuração do ajax com token csrf
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            carregarCargos();

            // ao exibir o modal, procura o input com autofocus e seleciona ele
            $('.modal').on('shown.bs.modal',function() {
                $(this).find('[autofocus]').focus();
            });
        });

        //function novaCategoria(){
        function novoCargo(){
            $('#id').val('');
            $('#nomeCargo').val('');

            $("#span").remove(); //remove a linha do span
            // exibe o modal cadastrar categorias
            $('#dlgCargos').modal('show');
        }

        function montarLinha(cat){
            //cria um html da linha da tabela
            var linha = "<tr>" +
                "<td>"+cat.id+"</td>"+
                "<td>"+cat.nome+"</td>"+
                "<td>"+
                "<a href="+"#"+" onclick="+"editarCargos("+cat.id+")"+">"+
                "<img id="+"iconeEdit"+" class="+"icone"+" src="+"{{asset('img/edit-solid.svg')}}"+" style="+""+">"+
                "</a>"+
                "<a href="+"#"+" onclick="+"removerCargo("+cat.id+")"+">"+
                "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/trash-alt-solid.svg')}}"+" style="+""+">"+
                "</a>"+
                "</td>"+
                "</tr>";
            return linha;
        }
        function editarCargos(id){
            console.log(id);
            $.getJSON('/api/cargos/'+id, function(data){
                // console.log(data);
                $('#id').val(data.id);
                $('#nomeCargo').val(data.nome);

                $("#span").remove(); //remove a linha do span
                //exibe Modal Cadastrar Categoria
                $('#dlgCargos').modal('show');
            });
        }

        function removerCargo(id){
            confirma = confirm("Você tem certeza que deseja remover a categoria?");
            if(confirma){
                $.ajax({
                    type: "DELETE",
                    url: "/api/cargos/"+id,
                    context: this,
                    success: function(){
                        console.log("deletou");
                        linhas = $("#tabelaCargos>tbody>tr");
                        e = linhas.filter(function(i,elemento){
                            return elemento.cells[0].textContent == id;//faz um filtro na linha e retorna a que tiver o id igual ao informado

                        });
                        if(e){
                            e.remove();
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }

                });
            }

        }
        function carregarCargos(){
            $.getJSON('/api/cargos', function(cargos){

                for(i=0; i < cargos.length;i++){
                    linha = montarLinha(cargos[i]);
                    $('#tabelaCargos>tbody').append(linha);
                }
            });
        }

        function criarCargo(){
            cargo = {
                nome: $('#nomeCargo').val()
            };


            $.ajax({
            type: "POST",
            url: "/api/cargos",
            context:this,
            data:cargo,
            success: function(data){
                categoria = JSON.parse(data);
                linha = montarLinha(categoria);
                $('#tabelaCargos>tbody').append(linha);
                $('#dlgCargos').modal('hide');
                },
            error:function(error){
                retorno = JSON.parse(error.responseText);
                exibirErros(retorno.errors);

                }
            });
        }

        function exibirErros(error){
            $("#span").remove(); //remove a linha do span
            if(error){
                linha = "<span id="+"span"+" style="+"color:red"+">"+error.nome[0]+"</span>";
                $('.validationCargo').append(linha);
                console.log(error.nome[0]);
            }
        }
        function salvarCargo(){
            $("#span").remove(); //remove a linha do span
            cargo = {
                id: $('#id').val(),
                nome: $('#nomeCargo').val()
            };
            // faz requisição PUT para /api/categorias passando o id da categoria que deseja editar
            $.ajax({
                type: "PUT",
                url: "/api/cargos/"+cargo.id,
                context: this,
                data: cargo,
                success: function(data){
                    console.log(cargo);
                    cargo = JSON.parse(data);
                    console.log("salvou OK");
                    linhas = $('#tabelaCargos>tbody>tr');
                    $("#dlgCargos").modal('hide');
                    e = linhas.filter(function(i,elemento){
                        return (elemento.cells[0].textContent == cargo.id);
                    });
                    console.log(e);

                    if(e){
                        e[0].cells[0].textContent = cargo.id;
                        e[0].cells[1].textContent = cargo.nome;
                    }

                },
                error: function(error){
                    console.log(error);
                    retorno = JSON.parse(error.responseText);
                    exibirErros(retorno.errors);
                }
            });
        }
        $(function () {
            $('#formCargo').submit(function (event) {
                event.preventDefault();
                if($('#id').val()!= '')
                    salvarCargo();
                else
                    criarCargo();
                // $("#dlgCargos").modal('hide');

            })

        });



    </script>

@endsection
