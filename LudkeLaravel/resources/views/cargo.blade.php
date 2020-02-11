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
                            <button class="btn btn-primary-ludke" role="button" onclick="novoCargo()">Novo</button>
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
                    </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table> <!-- end table -->
            </div><!-- end col-->
        </div><!-- end row-->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="dlgCargos">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formCargos" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Cargo</h5>
                    </div>
                    <div class="modal-body">

                        {{-- ID do CArgo --}}
                        <input type="hidden" id="id" class="form-control">

                        {{-- Nome do Cargo --}}
                        <div class="form-group">
                            <label for="nomeCargo" class="control-label">Nome do Cargo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nomeCargo" placeholder="Nome do Cargo">
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
        // $('input#inputBusca').quicksearch('table#tabelaProdutos tbody tr');

        //essa função é chamada sempre que atualiza a pagina
        $(function(){
            // Configura o ajax para todas as requisições ir com token csrf
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            carregarCargos();

            // Função para aparecer icone de excluir foto



        });


        // Sempre que clica no botão novo, limpa os campos do modal
        function novoCargo(){
            // Limpa campos do modal
            $('#id').val('');
            $('#nomeCargo').val('');
            // exibe modal cadastrar Produtos
            $('#dlgCargos').modal('show');
            console.log(#nomeCargo);

        }

        // carrega categorias da api e coloca no select
        // cria um html da linha da tabela
        function montarLinha(p){
            var linha = "<tr>"+
                "<td>"+p.id+"</td>"+
                "<td>"+p.nome+"</td>"+
                "</tr>";
            return linha;
        }

        function editarCargos(id){
            console.log("Editar");

            // Limpa o input de imagens, caso alguma imagem tenha sido carregada anteriormente


            // getJSON já faz o parser do dado recebido para json
            $.getJSON('/api/cargos/'+id, function(data){
                console.log(data);
                $('#id').val(data.id);
                $('#nomeCargo').val(data.nome);
                // exibe modal cadastrar Produtos
                $('#dlgCargos').modal('show');

                // limpa o array contendo o id das imagens para deletar
            });
        }
        function removerCargo(id){

            // exibe alerta de confirmação
            confirma = confirm("Você tem certeza que deseja remover o produto com ID = "+id+"?");
            // se o usuário confirmar
            if(confirma){
                // faz requisição DELETE para /api/produtos passando o id do produto que deseja apagar
                $.ajax({
                    type: "DELETE",
                    url: "/api/cargos/"+id,
                    context: this,
                    success: function(){
                        console.log("Deletou");
                        linhas = $("#tabelaCargos>tbody>tr");//pega linha da tabela
                        e = linhas.filter(function(i,elemento){
                            return elemento.cells[0].textContent == id;//faz um filtro na linha e retorna a que tiver o id igual ao informado
                        });
                        if(e){
                            e.remove();// remove a linha
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }


        }
        // carrega produtos do banco através da api e chama a função montarLinha para colocar na tabela
        function carregarCargos(){
            $.getJSON('/api/cargos',function(cargos){
                for(i=0;i<cargos.length;i++){
                    linha = montarLinha(produtos[i]);
                    $('#tabelaCargos>tbody').append(linha);
                }
            });
        }


        // função para fazer requisição post para o controller
        function criarCargo(){


            cargo = {
                nome: $('#nomeCargo').val(),
                // fotosProduto: imagensProduto
            };
            console.log(prod);

            // cria um FormData para ser enviado ao controller com os dados da requisição presentes no formulário
            let form = document.getElementById('formCargo');
            let formData = new FormData(form);
            formData.append('nome',cargo.nome);

            // formData.append('fotosProduto',prod.imagensProduto);

            // console.log(formData);
            $.ajax({
                url:'/api/cargos',
                method:"POST",
                data:formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(cargo){
                    // produto = JSON.parse(data);//converter o dado retornado para JSON ocorrerá um erro, pois o dado retornado é um object
                    linha = montarLinha(cargo); //monta a linha html para exibir o novo produto adicionado
                    $('#tabelaCargos>tbody').append(linha);//injeta a linha na tabela


                }
            })


        }

        function salvarCargos(){

            cargo = {
                id: $('#id').val(),
                nome: $('#nomeCargo').val(),
            };


            // console.log(prod.imagensProduto);
            let form = document.getElementById('formCargos');
            let formData = new FormData(form);

            console.log("valores do FormData");
            for(value of formData.values())
                console.log(value);

            formData.append('id',cargo.id);
            formData.append('nome',cargo.nome);


            console.log("valores do FormData");
            for(value of formData.values())
                console.log(value + typeof(value));
            // for(var value of formData.entries())
            //     console.log(value);

            // formData = formData.serializeArray();


            $.ajax({
                url:'/api/cargos/'+cargo.id,
                method:"POST",
                data:formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(cargos){
                    // console.log(JSON.parse(data));
                    // prod = JSON.parse(data); //converte a string data para um objeto json
                    console.log("Salvou OK");
                    linhas = $('#tabelaCargos>tbody>tr'); //pega todas as linhas da tabela
                    e = linhas.filter(function(i,elemento){//faz uma filtragem e retorna a linha que contem o id do produto atualizado
                        return (elemento.cells[0].textContent == cargos.id);
                    });
                    // console.log(e);
                    // se encontrou a linha, atualiza cada coluna
                    if(e){
                        e[0].cells[0].textContent = cargo.id;
                        e[0].cells[1].textContent = cargo.nome;
                    }
                },
                error: function(error){
                    // limpa o array contendo o id das imagens para deletar
                    arrayIdsDeletarFotos.length = 0;
                    console.log(error);
                }
            });

        }

        // função chamada sempre que a tela é atualizada
        $(function(){
            // função chamada sempre que clica no botão submit do formulário
            $('#formCargos').submit(function(event){
                event.preventDefault(); // não deixa fechar o modal quando clica no submit

                if($('#id').val()!= ''){
                    // limparArrayIdsFotos();
                    salvarCargos();// função chamada para editar produto
                }
                else{
                    // limparArrayIdsFotos();
                    criarCargo();// função que faz a requisição para o controller
                }
                $("#dlgProdutos").modal('hide'); //esconde o modal após fazer a requisição
            });
        });


    </script>

@endsection
