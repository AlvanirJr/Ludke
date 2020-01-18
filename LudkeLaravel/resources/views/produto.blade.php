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
                        <button class="btn btn-primary-ludke" role="button" onclick="novoProduto()">Novo</button>
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
            <table id="tabelaProdutos" class="table table-hover table-responsive-sm">
                <thead class="thead-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Validade</th>
                        {{-- <th>Quantidade</th> --}}
                        <th>Preço(R$)</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table> <!-- end table -->
        </div><!-- end col-->
    </div><!-- end row-->
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="dlgProdutos">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formProduto">
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

                    {{-- Preço do produto --}}
                    <div class="form-group">
                        <label for="precoProduto" class="control-label">Preço do Produto (por Kg)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="precoProduto" placeholder="Preço do Produto">
                        </div>
                    </div>

                    {{-- Input Fotos Produto --}}
                    <div class="form-group">
                        <label for="imagensProduto" class="control-label">Selecionar Imagens</label>
                        <div class="input-group">
                            <input type="file" name="imagensProduto[]" class="form-control-file" id="imagensProduto" placeholder="Preço do Produto" multiple>
                        </div>
                    </div>

                    {{-- foto --}}
                    <div class="row">
                        <div class="fotos col-sm-12">
                            <ul class="none">
                                @for($i=0;$i<=5;$i++)
                                <li>
                                    <div id="{{$i}}" class="fotoProduto">
                                        <div class="excluirFoto" onclick="excluirFoto({{$i}})"></div>
                                    </div>
                                </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    {{-- Descrição do produto --}}
                    <div class="form-group">
                        <label for="descricaoProduto" class="control-label">Descrição do Produto</label>
                        <div class="input-group">
                            <textarea class="form-control" id="descricaoProduto" placeholder="Descrição do Produto"></textarea>
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
    // $('input#inputBusca').quicksearch('table#tabelaProdutos tbody tr');

    //essa função é chamada sempre que atualiza a pagina
    $(function(){        
        // Configura o ajax para todas as requisições ir com token csrf
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        carregarCategorias();
        carregarProdutos();        

        // Função para aparecer icone de excluir foto
        exibirBotaoExcluirFoto();

    });
    
    function exibirBotaoExcluirFoto(){
        $('.fotoProduto').mouseover(function(){
            var idElemento = $(this).attr("id");
            $(this).children().css("display","block");
            // $(this).children().fadeIn(80);
        });
        $('.fotoProduto').mouseout(function(){
            var idElemento = $(this).attr("id");
            $(this).children().css("display","none");
            // $(this).children().fadeOut(80);
        });
    }
    
    function excluirFoto(id){
        console.log("Excluir Foto com id: "+id);
    }

    // Sempre que clica no botão novo, limpa os campos do modal
    function novoProduto(){
        // Limpa campos do modal
        $('#id').val('');
        $('#nomeProduto').val('');
        $('#categoriaProduto').val('');
        $('#validadeProduto').val('');
        $('#imagensProduto').val('');
        $('#precoProduto').val('');
        $('#descricaoProduto').val('');
        // exibe modal cadastrar Produtos
        $('#dlgProdutos').modal('show');
    }

    // carrega categorias da api e coloca no select
    function carregarCategorias(){
        $.getJSON('/api/categorias',function(data){
            // console.log(data);

            for(i=0 ; i<data.length; i++){
                // adiciona cada categoria no select do formulário
                opcao = '<option value="'+data[i].id+'">'+data[i].nome+'</option>';
                $('#categoriaProduto').append(opcao);
            }
        });
    }

    // cria um html da linha da tabela
    function montarLinha(p){
        var linha = "<tr>"+
                        "<td>"+p.id+"</td>"+
                        "<td>"+p.nome+"</td>"+
                        "<td>"+p.categoria_id+"</td>"+
                        "<td>"+p.validade+"</td>"+
                        // "<td>"+p.quantidade+"</td>"+
                        "<td>"+p.preco+"</td>"+
                        "<td>"+p.descricao+"</td>"+
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
    function editarProduto(id){
        console.log("Editar");
        // getJSON já faz o parser do dado recebido para json
        $.getJSON('/api/produtos/'+id, function(data){
            console.log(data);
            $('#id').val(data.id);
            $('#nomeProduto').val(data.nome);
            $('#categoriaProduto').val(data.categoria_id);
            $('#validadeProduto').val(data.validade);
            // $('#quantidadeProduto').val(data.quantidade);
            $('#precoProduto').val(data.preco);
            $('#descricaoProduto').val(data.descricao);


            // exibe modal cadastrar Produtos
            $('#dlgProdutos').modal('show');
        });
    }
    function removerProduto(id){
        
        // exibe alerta de confirmação
        confirma = confirm("Você tem certeza que deseja remover o produto com ID = "+id+"?");
        // se o usuário confirmar 
        if(confirma){
            // faz requisição DELETE para /api/produtos passando o id do produto que deseja apagar
            $.ajax({
                type: "DELETE",
                url: "/api/produtos/"+id,
                context: this,
                success: function(){
                    console.log("Deletou");
                    linhas = $("#tabelaProdutos>tbody>tr");//pega linha da tabela
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
    function carregarProdutos(){
        $.getJSON('/api/produtos',function(produtos){
            for(i=0;i<produtos.length;i++){
                linha = montarLinha(produtos[i]);
                $('#tabelaProdutos>tbody').append(linha);
            }
        });
    }

    // função para fazer requisição post para o controller
    function criarProduto(){
        // cria um objeto com os dados do form
        var imagensProduto = document.getElementById("imagensProduto").files;
        var imagensProduto = document.getElementById("imagensProduto").files;
        // console.log(imagensProduto);

        prod = {
            nome: $('#nomeProduto').val(), 
            validade: $('#validadeProduto').val(), 
            preco: $('#precoProduto').val(), 
            descricao: $('#descricaoProduto').val(), 
            categoria_id: $('#categoriaProduto').val(),
            // fotosProduto: imagensProduto
        };
        console.log(prod);

        // // faz uma requisição post para a rota /api/produtos
        // $.post('/api/produtos',prod,function(data){
        //     produto = JSON.parse(data);//converte para json o objeto retornado do controller
        //     linha = montarLinha(produto); //monta a linha html para exibir o novo produto adicionado
        //     $('#tabelaProdutos>tbody').append(linha);//injeta a linha na tabela
        // });

        let form = document.getElementById('formProduto');
        let formData = new FormData(form);
        formData.append('nome',prod.nome);
        formData.append('validade',prod.validade);
        formData.append('preco',prod.preco);
        formData.append('descricao',prod.descricao);
        formData.append('categoria_id',prod.categoria_id);
        // formData.append('fotosProduto',prod.imagensProduto);
        
        console.log(formData);
        $.ajax({
            url:'/api/produtos',
            method:"POST",
            data:formData,
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(produto){
                // produto = JSON.parse(data);//converte para json o objeto retornado do controller
                linha = montarLinha(produto); //monta a linha html para exibir o novo produto adicionado
                $('#tabelaProdutos>tbody').append(linha);//injeta a linha na tabela
            }
        })
        

    }
    
    function salvarProduto(){
        // cria um objeto com os dados do form
        prod = {
            id: $('#id').val(),
            nome: $('#nomeProduto').val(), 
            validade: $('#validadeProduto').val(), 
            // quantidade: $('#quantidadeProduto').val(), 
            preco: $('#precoProduto').val(), 
            descricao: $('#descricaoProduto').val(), 
            categoria_id: $('#categoriaProduto').val()            
        };

        // faz requisição PUT para /api/produtos passando o id do produto que deseja editar
        $.ajax({
                type: "PUT",
                url: "/api/produtos/"+prod.id,
                context: this,
                data: prod,
                success: function(data){
                    prod = JSON.parse(data); //converte a string data para um objeto json
                    console.log("Salvou OK");
                    linhas = $('#tabelaProdutos>tbody>tr'); //pega todas as linhas da tabela
                    e = linhas.filter(function(i,elemento){//faz uma filtragem e retorna a linha que contem o id do produto atualizado
                        return (elemento.cells[0].textContent == prod.id);
                    });
                    console.log(e);
                    // se encontrou a linha, atualiza cada coluna
                    if(e){
                        e[0].cells[0].textContent = prod.id;
                        e[0].cells[1].textContent = prod.nome;
                        e[0].cells[2].textContent = prod.categoria_id;
                        e[0].cells[3].textContent = prod.validade;
                        // e[0].cells[4].textContent = prod.quantidade;
                        e[0].cells[4].textContent = prod.preco;
                        e[0].cells[5].textContent = prod.descricao;
                    }

                },
                error: function(error){
                    console.log(error);
                }
            });
    }

    // função chamada sempre que a tela é atualizada
    $(function(){
        // função chamada sempre que clica no botão submit do formulário
        $('#formProduto').submit(function(event){
            event.preventDefault(); // não deixa fechar o modal quando clica no submit
            
            if($('#id').val()!= '')
                salvarProduto();// função chamada para editar produto
            else
                criarProduto();// função que faz a requisição para o controller
            $("#dlgProdutos").modal('hide'); //esconde o modal após fazer a requisição
        });
    });

    
</script>
    
@endsection