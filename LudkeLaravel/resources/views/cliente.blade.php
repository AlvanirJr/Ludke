@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="titulo-pagina-nome">
                            <h2>Clientes</h2>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-primary-ludke" role="button" onclick="novoCliente()">Novo</button>
                    </div>
                    <div class="col-md-4 input-group">
                        {{-- <input id="inputBusca" class="form-control input-ludke" type="text" placeholder="Pesquisar" name="pesquisar"> --}}
                        <form action="{{route('buscarCliente')}}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input name="q" type="text" class="form-control" placeholder="Buscar Cliente" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                  <button class="btn btn-primary-ludke" type="submit">Buscar</button>
                                </div>
                              </div>
                        </form>

                    </div>
                </div>
            </div><!-- end titulo-pagina -->
        </div><!-- end col-->
    </div><!-- end row-->
    
    {{-- botão listar Todos --}}
    @if(isset($achou) && $achou == true)
    <div class="row">
        <div class="col-sm-12 limparBusca">
            <a href="{{route('clientes')}}">
                <button class="btn btn-outline-danger">Listar Todos</button>
            </a>

        </div>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-sm-12">
            @if(isset($clientes))
            <table id="tabelaClientes" class="table table-hover table-responsive-xl">
                <thead class="thead-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone Residêncial</th>
                        <th>Celular</th>                        
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{$cliente->id}}</td>
                        <td>{{$cliente->user->name}}</td>
                        <td>{{$cliente->cpfCnpj}}</td>
                        <td>{{$cliente->user->telefone->residencial}}</td>
                        <td>{{$cliente->user->telefone->celular}}</td>
                        <td>
                            <a href="#" onclick="editarCliente({{$cliente->id}})">
                               <img id="iconeEdit" class="icone" src="{{asset('img/edit-solid.svg')}}">
                            </a>                            
                            <a href="#" onclick="removerCliente({{$cliente->id}})">
                                <img id="iconeDelete" class="icone" src="{{asset('img/trash-alt-solid.svg')}}">
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> <!-- end table -->

            <div class="row justify-content-center">
                {{ $clientes->render() }}
            </div>
            @else
            <div class="row">
                <div class="col-sm-12 limparBusca">
                    <a href="{{route('clientes')}}">
                        <button class="btn btn-outline-danger">Listar Todos</button>
                    </a>
    
                </div>
            </div>
            {{-- Mensagem Alerta --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert">
                        {{$menssage}}
                    </div>
                </div>
            </div>
            
            @endif
        </div><!-- end col-->
    </div><!-- end row-->
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="dlgClientes">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formCliente">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Novo Cliente</h5>
                </div>
                <div class="modal-body">
                    
                    {{-- ID do produto --}}
                    <input type="hidden" id="id" class="form-control">

                    {{-- row dados pessoais --}}
                    <div class="row justify-content-left">
                        <div class="col-sm-12">
                            <h3 id="categoriaForm">Dados Pessoais</h3>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        {{-- Nome do funcionário --}}
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nomeCliente" class="control-label">Nome do Cliente <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nomeCliente" placeholder="Nome do Cliente" autofocus>
                                </div>
                                <div id="validationNome"></div>
                            </div>
                        </div>
                        
                    </div>

                    {{-- Nome reduzido + nome responsável --}}
                    <div class="row justify-content-center">
                        {{-- Nome reduzido --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nomeReduzido" class="control-label">Nome Reduzido</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nomeReduzido" placeholder="Nome Reduzido">
                                </div>
                                <div id="validationNomeReduzido"></div>
                            </div>
                        </div>

                        {{-- Nome responsável --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nomeResponsavel" class="control-label">Nome do Responsável</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nomeResponsavel" placeholder="Nome do Responsável">
                                </div>
                                <div id="validationNomeResponsavel"></div>
                            </div>
                        </div>
                    </div>

                    {{-- row nome + cargo --}}
                    <div class="row justify-content-center">
                        
                        {{-- cpf/cnpj --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cpfCnpj" class="control-label">CPF/CNPJ <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="cpfCnpj" placeholder="CPF/CNPJ">
                                </div>
                                <div id="validationCpfCnpj"></div>
                            </div>
                        </div>
                        
                        {{-- tipo do cliente --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cargoFuncionario" class="control-label">Tipo <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <select class="form-control" id="tipo">
                                        <option value="" disabled selected hidden>-- Tipo --</option>
                                        <option value="pessoaFisica">PESSOA FÍSICA</option>
                                        <option value="pessoaJuridica">PESSOA JURÍDICA</option>
                                    </select>
                                </div>
                                <div id="validationTipo"></div>
                            </div>
                        </div>
                    </div>

                    {{-- row telefones --}}
                    <div class="row justify-content-center">
                        
                        {{-- Nome do funcionário --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="residencial" class="control-label">Telefone Residêncial</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="residencial" placeholder="Telefone Residêncial">
                                </div>
                                <div id="validationResidencial"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{-- Nome do funcionário --}}
                            <div class="form-group">
                                <label for="celular" class="control-label">Telefone Celular</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="celular" placeholder="Telefone Celular">
                                </div>
                                <div id="validationCelular"></div>
                            </div>
                        </div>

                    </div>

                    <div class="row justify-content-center">
                        {{-- inscricao estadual --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inscricaoEstadual" class="control-label">Inscrição Estadual</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inscricaoEstadual" placeholder="Inscrição Estadual">
                                </div>
                                <div id="validationInscricaoEstadual"></div>
                            </div>
                        </div>

                        {{-- email do funcionário --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="emailCliente" class="control-label">E-mail do Cliente <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="emailCliente" placeholder="E-mail do Cliente">
                                </div>
                                <div id="validationEmail"></div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- row Endereço --}}
                    <div class="row justify-content-left">
                        <div class="col-sm-12">
                            <h3 id="categoriaForm">Endereço</h3>
                        </div>
                    </div>

                    {{-- row rua + CEP --}}
                    <div class="row justify-content-center">
                        
                        {{-- CEP--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cep" class="control-label">CEP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cep" placeholder="CEP">
                                </div>
                                <div id="validationCep"></div>
                            </div>
                        </div>

                        {{-- Rua--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rua" class="control-label">Rua <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="rua" placeholder="Rua">
                                </div>
                                <div id="validationRua"></div>
                            </div>
                        </div>


                    </div>

                    {{-- row bairro + cidade + UF --}}
                    <div class="row justify-content-center">
                        {{-- Bairro--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="bairro" class="control-label">Bairro <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="bairro" placeholder="Bairro">
                                </div>
                                <div id="validationBairro"></div>
                            </div>
                        </div>

                        {{-- Cidade--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cidade" class="control-label">Cidade <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cidade" placeholder="Cidade">
                                </div>
                                <div id="validationCidade"></div>
                            </div>
                        </div>

                        
                    </div>
                    {{-- row UF + Número --}}
                    <div class="row justify-content-center">
                        {{-- UF--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="uf" class="control-label">UF <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <select class="form-control" id="uf">
                                        <option value="" disabled selected hidden>-- UF --</option>
                                    </select>
                                </div>
                                <div id="validationUf"></div>
                            </div>
                        </div>

                        {{-- Número--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="numero" class="control-label">Número <span class="obrigatorio">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="numero" placeholder="Número">
                                </div>
                                <div id="validationNumero"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        {{-- UF--}}
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="complemento" class="control-label">Complemento</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="complemento" placeholder="Complemento">
                                </div>
                                <div id="validationComplemento"></div>
                            </div>
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
<script>

    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        carregarEstados();
        // carregarClientes();

        // ao exibir o modal, procura o input com autofocus e seleciona ele
        $('.modal').on('shown.bs.modal',function() {
            $(this).find('[autofocus]').focus();
        });
    });

    function carregarClientes(){
        // console.log('clientes');
        $.getJSON('/clientes',function(clientes){
            for(i=0; i<clientes.length;i++){
                // console.log(clientes[i]);
                linha = montarLinha(clientes[i]);
                $('#tabelaClientes>tbody').append(linha);

            }
        });
    }

    function montarLinha(c){
        var linha = "<tr>"+
                        "<td>"+c.id+"</td>"+
                        "<td>"+c.nome+"</td>"+
                        "<td>"+c.cpfCnpj+"</td>"+
                        "<td>"+c.residencial+"</td>"+
                        "<td>"+c.celular+"</td>"+
                        "<td>"+
                            "<a href="+"#"+" onclick="+"editarCliente("+c.id+")"+">"+
                                "<img id="+"iconeEdit"+" class="+"icone"+" src="+"{{asset('img/edit-solid.svg')}}"+" style="+""+">"+
                            "</a>"+                            
                            "<a href="+"#"+" onclick="+"removerCliente("+c.id+")"+">"+
                                "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/trash-alt-solid.svg')}}"+" style="+""+">"+
                            "</a>"+
                        "</td>"+
                    "</tr>";
        return linha;
    }

    function editarCliente(id){
        $.getJSON("/clientes/"+id, function(data){
            $('#id').val(data.id);
            $('#nomeCliente').val(data.nome);
            $('#emailCliente').val(data.email);
            $('#nomeReduzido').val(data.nomeReduzido);
            $('#nomeResponsavel').val(data.nomeResponsavel);
            $('#cpfCnpj').val(data.cpfCnpj);
            $('#tipo').val(data.tipo);
            $('#inscricaoEstadual').val(data.inscricaoEstadual);
            
            $('#residencial').val(data.residencial);
            $('#celular').val(data.celular);
            $('#cep').val(data.cep);
            $('#rua').val(data.rua);
            $('#bairro').val(data.bairro);
            $('#cidade').val(data.cidade);
            $('#uf').val(data.uf);
            $('#numero').val(data.numero);
            $('#complemento').val(data.complemento);

            $(".span").remove(); //limpa os span de erro

            // exibe modal cadastrar Produtos
            $('#dlgClientes').modal('show');
        });
    }
    function removerCliente(id){
        confirma = confirm("Você tem certeza que deseja remover este cliente?");
        if(confirma){
            $.ajax({
                type: "DELETE",
                url: "/clientes/"+id,
                context: this,
                success: function(){
                    alert("Cliente deletado com sucesso!");
                    window.location.href="\indexClientes";
                    // console.log("Deletou Cliente");
                    // linhas = $("#tabelaClientes>tbody>tr");
                    // e = linhas.filter(function(i,elemento){
                    //     return elemento.cells[0].textContent== id;
                    // });
                    // if(e){
                    //     e.remove();
                    // }
                },
                error: function(error){
                    console.log(error);
                }

            });
        }
    }

    // lista de estados para o select UF
    function carregarEstados(){
        let estados = [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
            'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN',
            'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
            ];
            for(i = 0; i < estados.length; i++){
                opcao = '<option value="'+estados[i]+'">'+estados[i]+'</option>'
                // console.log(opcao);
                $('#uf').append(opcao);
            }
    }
    function novoCliente(){

        $('#id').val('');
        $('#nomeCliente').val('');
        $('#emailCliente').val('');
        $('#nomeReduzido').val('');
        $('#nomeResponsavel').val('');
        $('#cpfCnpj').val('');
        $('#tipo').val('');
        $('#inscricaoEstadual').val('');
        
        $('#residencial').val('');
        $('#celular').val('');
        $('#cep').val('');
        $('#rua').val('');
        $('#bairro').val('');
        $('#cidade').val('');
        $('#uf').val('');
        $('#numero').val('');
        $('#complemento').val('');

        $(".span").remove(); //limpa os span de erro

        // exibe modal cadastrar Produtos
        $('#dlgClientes').modal('show');
    }
    function salvarCliente(){
        console.log('Salvar Cliente');

        cliente = {
            id: $('#id').val(),
            nome: $('#nomeCliente').val(),
            email: $('#emailCliente').val(),
            nomeReduzido: $('#nomeReduzido').val(),
            nomeResponsavel: $('#nomeResponsavel').val(),
            cpfCnpj: $('#cpfCnpj').val(),
            tipo: $('#tipo').val(),
            inscricaoEstadual: $('#inscricaoEstadual').val(),
            
            residencial: $('#residencial').val(),
            celular: $('#celular').val(),
            cep: $('#cep').val(),
            rua: $('#rua').val(),
            bairro: $('#bairro').val(),
            cidade: $('#cidade').val(),
            uf: $('#uf').val(),
            numero: $('#numero').val(),
            complemento: $('#complemento').val()
        }

        $.ajax({
            type: "PUT",
            url: "/clientes/"+cliente.id,
            context: this,
            data: cliente,
            success: function(data){
                cli = JSON.parse(data);
                alert("Cliente "+cli.nome+" salvo com sucesso!")
                window.location.href="\indexClientes";
                // cli = JSON.parse(data);
                // linhas = $('#tabelaClientes>tbody>tr');
                // e = linhas.filter(function(i,elemento){
                //     return (elemento.cells[0].textContent == cliente.id);
                // });
                // if(e){
                //     e[0].cells[0].textContent = cliente.id;
                //     e[0].cells[1].textContent = cliente.nome;
                //     e[0].cells[2].textContent = cliente.cpfCnpj;
                //     e[0].cells[3].textContent = cliente.residencial;
                //     e[0].cells[4].textContent = cliente.celular;

                // }
                // $('#dlgClientes').modal('hide');
            },
            error: function(error){
                    console.log(error);
                    retorno = JSON.parse(error.responseText);
                    exibirErros(retorno.errors);
                }
        });

    }

    function criarCliente(){
        console.log('Criar Cliente');

        cliente = {
            nome: $('#nomeCliente').val(),
            email: $('#emailCliente').val(),
            nomeReduzido: $('#nomeReduzido').val(),
            nomeResponsavel: $('#nomeResponsavel').val(),
            cpfCnpj: $('#cpfCnpj').val(),
            tipo: $('#tipo').val(),
            inscricaoEstadual: $('#inscricaoEstadual').val(),
            
            residencial: $('#residencial').val(),
            celular: $('#celular').val(),
            cep: $('#cep').val(),
            rua: $('#rua').val(),
            bairro: $('#bairro').val(),
            cidade: $('#cidade').val(),
            uf: $('#uf').val(),
            numero: $('#numero').val(),
            complemento: $('#complemento').val()
        }

        $.ajax({
                type: "POST",
                url: "/clientes",
                context: this,
                data: cliente,
                success: function(data){
                    cliente = JSON.parse(data);
                    alert("Cliente "+cliente.nome+" cadastrado com sucesso!");
                    window.location.href="\indexClientes";
                    // cliente = JSON.parse(data);
                    // linha = montarLinha(cliente);
                    // $('#tabelaClientes>tbody').append(linha);
                    // $('#dlgClientes').modal('hide');
                },
                error: function(error){
                    retorno = JSON.parse(error.responseText);
                    
                    exibirErros(retorno.errors);
                    
                }

            });
    }
    function exibirErros(error){
        console.log(error);
        $(".span").remove(); //limpa os span de erro
        if(error){
            if(error.nome){
                for(i=0;i<error.nome.length;i++){
                    console.log(error.nome[i]);
                    $("#validationNome").append("<span class="+"span"+" style="+"color:red"+">"+error.nome[i]+"</span>");
                }
            }
            if(error.email){
                for(i=0;i<error.email.length;i++){
                    console.log(error.email[i]);
                    $("#validationEmail").append("<span class="+"span"+" style="+"color:red"+">"+error.email[i]+"</span>");
                }
            }
            if(error.cpfCnpj){
                for(i=0;i<error.cpfCnpj.length;i++){
                    console.log(error.cpfCnpj[i]);
                    $("#validationCpfCnpj").append("<span class="+"span"+" style="+"color:red"+">"+error.cpfCnpj[i]+"</span>");
                }
            }
            if(error.tipo){
                for(i=0;i<error.tipo.length;i++){
                    console.log(error.tipo[i]);
                    $("#validationTipo").append("<span class="+"span"+" style="+"color:red"+">"+error.tipo[i]+"</span>");
                }
            }
            if(error.residencial){
                for(i=0;i<error.residencial.length;i++){
                    console.log(error.residencial[i]);
                    $("#validationResidencial").append("<span class="+"span"+" style="+"color:red"+">"+error.residencial[i]+"</span>");
                }
            }
            if(error.celular){
                for(i=0;i<error.celular.length;i++){
                    console.log(error.celular[i]);
                    $("#validationCelular").append("<span class="+"span"+" style="+"color:red"+">"+error.celular[i]+"</span>");
                }
            }
            if(error.cep){
                for(i=0;i<error.cep.length;i++){
                    console.log(error.cep[i]);
                    $("#validationCep").append("<span style="+"color:red"+">"+error.cep[i]+"</span>")
                }
            }
            if(error.rua){
                for(i=0;i<error.rua.length;i++){
                    console.log(error.rua[i]);
                    $("#validationRua").append("<span class="+"span"+" style="+"color:red"+">"+error.rua[i]+"</span>")
                }
            }
            if(error.bairro){
                for(i=0;i<error.bairro.length;i++){
                    console.log(error.bairro[i]);
                    $("#validationBairro").append("<span class="+"span"+" style="+"color:red"+">"+error.bairro[i]+"</span>")
                }
            }
            if(error.cidade){
                for(i=0;i<error.cidade.length;i++){
                    console.log(error.cidade[i]);
                    $("#validationCidade").append("<span class="+"span"+" style="+"color:red"+">"+error.cidade[i]+"</span>")
                }
            }
            if(error.uf){
                for(i=0;i<error.uf.length;i++){
                    console.log(error.uf[i]);
                    $("#validationUf").append("<span class="+"span"+" style="+"color:red"+">"+error.uf[i]+"</span>")
                }
            }
            if(error.numero){
                for(i=0;i<error.numero.length;i++){
                    console.log(error.numero[i]);
                    $("#validationNumero").append("<span class="+"span"+" style="+"color:red"+">"+error.numero[i]+"</span>")
                }
            }
            if(error.complemento){
                for(i=0;i<error.complemento.length;i++){
                    console.log(error.complemento[i]);
                    $("#validationComplemento").append("<span class="+"span"+" style="+"color:red"+">"+error.complemento[i]+"</span>")
                }
            }
        }
    }
    $(function(){
        $('#formCliente').submit(function(event){
            event.preventDefault();// não deixa fechar o modal quando clica no submit

            if($('#id').val()!= ''){
                
                salvarCliente();
            }
            else{
                
                criarCliente();
            }
            // $('#dlgClientes').modal('hide');
        });
    });
</script>
@endsection