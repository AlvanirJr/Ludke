@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-sm-12">
            <div class="titulo-pagina">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="titulo-pagina-nome">
                            <h2>Funcionários</h2>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-primary-ludke" role="button" onclick="novoFuncionario()">Novo</button>
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
            <table id="tabelaFuncionarios" class="table table-hover table-responsive-xl">
                <thead class="thead-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>Telefone Residêncial</th>
                        <th>Celular</th>
                        <th>CEP</th>
                        <th>Rua</th>
                        <th>Número</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>UF</th>
                        <th>Complemento</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table> <!-- end table -->
        </div><!-- end col-->
    </div><!-- end row-->
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="dlgFuncionarios">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formFuncionario">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Novo Funcionário</h5>
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
                                <label for="nomeFuncionario" class="control-label">Nome do Funcionario</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nomeFuncionario" placeholder="Nome do Funcionário">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- row nome + cargo --}}
                    <div class="row justify-content-center">
                        
                        {{-- Nome do funcionário --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="emailFuncionario" class="control-label">E-mail do Funcionario</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="emailFuncionario" placeholder="E-mail do Funcionário">
                                </div>
                            </div>
                        </div>
                        
                        {{-- Cargo do funcionário --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cargoFuncionario" class="control-label">Cargo do Funcionário</label>
                                <div class="input-group">
                                    <select class="form-control" id="cargoFuncionario">
                                        <option value="" disabled selected hidden>-- Cargo --</option>
                                    </select>
                                </div>
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
                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{-- Nome do funcionário --}}
                            <div class="form-group">
                                <label for="celular" class="control-label">Telefone Celular</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="celular" placeholder="Telefone Celular 1">
                                </div>
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
                            </div>
                        </div>

                        {{-- Rua--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rua" class="control-label">Rua</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="rua" placeholder="Rua">
                                </div>
                            </div>
                        </div>


                    </div>

                    {{-- row bairro + cidade + UF --}}
                    <div class="row justify-content-center">
                        {{-- Bairro--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="bairro" class="control-label">Bairro</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="bairro" placeholder="Bairro">
                                </div>
                            </div>
                        </div>

                        {{-- Cidade--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cidade" class="control-label">Cidade</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cidade" placeholder="Cidade">
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    {{-- row UF + Número --}}
                    <div class="row justify-content-center">
                        {{-- UF--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="uf" class="control-label">UF</label>
                                <div class="input-group">
                                    <select class="form-control" id="uf">
                                        <option value="" disabled selected hidden>-- UF --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Número--}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="numero" class="control-label">Número</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="numero" placeholder="Número">
                                </div>
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
    
    //essa função é chamada sempre que atualiza a pagina
    $(function(){        
        // Configura o ajax para todas as requisições ir com token csrf
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        carregarCargos(); 
        carregarFuncionarios();
        carregarEstados();     
    });

    function carregarFuncionarios(){
        // alert('funcionarios');
        console.log('funcionarios');
        $.getJSON('/api/funcionarios',function(funcionarios){
            // console.log(funcionarios);
            for(i=0; i<funcionarios.length;i++){
                console.log(funcionarios[i])
                linha = montarLinha(funcionarios[i]);
                $('#tabelaFuncionarios>tbody').append(linha);
            }
        });
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
    function carregarCargos(){
        $.getJSON('/api/cargos',function(data){
            // console.log(data);

            for(i = 0; i < data.length; i++){
                opcao = '<option value="'+data[i].id+'">'+data[i].nome+'</option>'
                $('#cargoFuncionario').append(opcao);
            }
        });
    }

    function novoFuncionario(){
        // Limpa campos do modal
        $('#id').val('');
        $('#emailFuncionario').val('');
        $('#nomeFuncionario').val('');
        $('#cargoFuncionario').val('');

        $('#residencial').val('');
        $('#celular').val('');
        $('#cep').val('');
        $('#rua').val('');
        $('#bairro').val('');
        $('#cidade').val('');
        $('#uf').val('');
        $('#numero').val('');
        $('#complemento').val('');
        
        // exibe modal cadastrar Produtos
        $('#dlgFuncionarios').modal('show');
    }

    function salvarFuncionario(){
        console.log('SalvarFuncionario');

        funcionario = {
            id: $('#id').val(),
            email: $('#emailFuncionario').val(),
            nome: $('#nomeFuncionario').val(),
            cargo: $('#cargoFuncionario').val(),
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
            url: "/api/funcionarios/"+funcionario.id,
            context: this,
            data: funcionario,
            success: function(data){
                func = JSON.parse(data);
                linhas = $('#tabelaFuncionarios>tbody>tr');
                e = linhas.filter(function(i,elemento){
                    return (elemento.cells[0].textContent == funcionario.id);
                });
                if(e){
                    e[0].cells[0].textContent = funcionario.id;
                    e[0].cells[1].textContent = funcionario.nome;
                    e[0].cells[2].textContent = funcionario.cargo;
                    e[0].cells[3].textContent = funcionario.residencial;
                    e[0].cells[4].textContent = funcionario.celular;
                    e[0].cells[5].textContent = funcionario.cep;
                    e[0].cells[6].textContent = funcionario.rua;
                    e[0].cells[7].textContent = funcionario.numero;
                    e[0].cells[8].textContent = funcionario.bairro;
                    e[0].cells[9].textContent = funcionario.cidade;
                    e[0].cells[10].textContent = funcionario.uf;
                    e[0].cells[11].textContent = funcionario.complemento;

                }
            },
            error: function(error){
                    console.log(error);
                }
        });
    }

     // cria um html da linha da tabela
     function montarLinha(f){
        var linha = "<tr>"+
                        "<td>"+f.id+"</td>"+
                        "<td>"+f.nome+"</td>"+
                        "<td>"+f.cargo+"</td>"+
                        "<td>"+f.residencial+"</td>"+
                        "<td>"+f.celular+"</td>"+
                        "<td>"+f.cep+"</td>"+
                        "<td>"+f.rua+"</td>"+
                        "<td>"+f.numero+"</td>"+
                        "<td>"+f.bairro+"</td>"+
                        "<td>"+f.cidade+"</td>"+
                        "<td>"+f.uf+"</td>"+
                        "<td>"+f.complemento+"</td>"+
                        "<td>"+
                            "<a href="+"#"+" onclick="+"editarFuncionario("+f.id+")"+">"+
                                "<img id="+"iconeEdit"+" class="+"icone"+" src="+"{{asset('img/edit-solid.svg')}}"+" style="+""+">"+
                            "</a>"+                            
                            "<a href="+"#"+" onclick="+"removerFuncionario("+f.id+")"+">"+
                                "<img id="+"iconeDelete"+" class="+"icone"+" src="+"{{asset('img/trash-alt-solid.svg')}}"+" style="+""+">"+
                            "</a>"+
                        "</td>"+
                    "</tr>";
        return linha;
    }
    function editarFuncionario(id){
        console.log("editar Funcionario");
        $.getJSON("/api/funcionarios/"+id, function(data){
            console.log(data);
            $('#id').val(data.id);
            $('#emailFuncionario').val(data.email),
            $('#nomeFuncionario').val(data.nome),
            $('#cargoFuncionario').val(data.cargo),
            $('#residencial').val(data.residencial),
            $('#celular').val(data.celular),
            $('#cep').val(data.cep),
            $('#rua').val(data.rua),
            $('#bairro').val(data.bairro),
            $('#cidade').val(data.cidade),
            $('#uf').val(data.uf),
            $('#numero').val(data.numero),
            $('#complemento').val(data.complemento)
            // exibe modal cadastrar Produtos
            $('#dlgFuncionarios').modal('show');
        });
    }
    function removerFuncionario(id){
        console.log("Remover Funcionario");
        confirma = confirm("Você tem certeza que deseja remover este funcionário?");
        if(confirma){
            $.ajax({
                type: "DELETE",
                url: "/api/funcionarios/"+id,
                context: this,
                success: function(){
                    console.log("Deletou Funcionario");
                    linhas = $("#tabelaFuncionarios>tbody>tr");
                    e = linhas.filter(function(i,elemento){
                        return elemento.cells[0].textContent == id;
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
    function criarFuncionario(){
        console.log('criarFuncionario');
        funcionario = {
            email: $('#emailFuncionario').val(),
            nome: $('#nomeFuncionario').val(),
            cargo: $('#cargoFuncionario').val(),
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
        // console.log(funcionario);
        $.post('/api/funcionarios',funcionario,function(data){
            // console.log('Requisição para /api/funcionarios');
            funcionario = JSON.parse(data);
            linha = montarLinha(funcionario);
            $('#tabelaFuncionarios>tbody').append(linha);
        });
        
    }
    $(function(){
        $('#formFuncionario').submit(function(event){
            event.preventDefault();// não deixa fechar o modal quando clica no submit

            if($('#id').val()!= ''){
                console.log('Salvar Funcionário');
                salvarFuncionario();
            }
            else{
                console.log('Criar Funcionário');
                criarFuncionario();
            }
            $('#dlgFuncionarios').modal('hide');
        });
    });
</script>
@endsection