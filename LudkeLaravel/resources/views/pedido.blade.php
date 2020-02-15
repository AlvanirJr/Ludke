@extends('layouts.app')

@section('content')

<div id="conteudo-pedidos" class="container-fluid">
    
    <div class="row justify-content-center">
        {{-- Coluna 1 --}}
        <div class="col-sm-6">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    {{-- Card Cliente --}}
                    <div id="cardCliente" class="card card-pedidos">
                        <div class="card-header">Cliente</div>
                        <div class="card-body">
                            <form id="formCliente">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <input type="hidden" id="cliente_id">
                                                    <input id="cpfCnpj" type="text" class="form-control" placeholder="CPF / CNPJ">
                                                </div>
                                                <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-primary-ludke">Adicionar</button>
                                                </div>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Nome</label>
                                        <h4 id="nomeCliente"></h4>
                                    </div>
                                </div>
                            </form> {{-- Form cliente--}}

                        </div>
                        
                    </div>{{-- end Card Cliente --}}
                </div>
            </div>
            {{-- Row Produto --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    {{-- Card Produto --}}
                    <div id="cardProduto" class="card card-pedidos">
                        <div class="card-header">Produto</div>
                        <div class="card-body">
                            <form id="formProduto">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Nome do Produto">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" placeholder="Peso">
                                                </div>
                                                <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-primary-ludke">Adicionar</button>
                                                </div>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                            </form> {{-- Form cliente--}}

                            {{-- informações do produto --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Nome</label>
                                            <h4> 2 itens</h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Preço/Kg</label>
                                            <h4>R$ 12,00</h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Preço</label>
                                            <h4>R$ 12,00</h4>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Descrição</label>
                                            <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </h4>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>{{-- informações do produto --}}
                        </div>
                    </div>{{-- end Card Produto --}}
                </div>
            </div>{{-- end Row Produto --}}

            <div class="row">
                <div class="col-sm-6">
                    <a href="" class="btn btn-secondary-ludke btn-pedido">Cancelar Pedido</a>
                </div>
                <div class="col-sm-6">
                    <a href="" class="btn btn-primary-ludke btn-pedido">Finalizar Pedido</a>
                </div>
            </div>

        </div>{{-- end Coluna 1 --}}

        {{-- Coluna 2 --}}

        <div class="col-sm-6">
            <div class="row justify-content-center">
                <div class="col-sm-12">

                    <div class="card card-pedidos">
                        <div class="card-header">Pedido</div>
                        <div id="listaPedidos" class="card-body">
                            <table class="table table-responsive-lg table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>COD</th>
                                        <th>NOME</th>
                                        <th>PESO</th>
                                        <th>PREÇO/KG</th>
                                        <th>VALOR TOTAL</th>
                                        <th>AÇÕES</th>

                                    </tr>
                                </thead>
                                <tbody >

                                    @for ($i = 0; $i < 20; $i++)
                                        
                                    <tr>
                                        <td>Cod</td>
                                        <td>Nome</td>
                                        <td>Peso</td>
                                        <td>Valor/Peso</td>
                                        <td>Valor Total</td>
                                        <td>Ações</td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>{{--  end lista produtos--}}
                
            </div>

            {{-- Row Informações Venda --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    {{-- Card Venda --}}
                    <div id="card-venda" class="card card-pedidos">
                        <div class="card-header">Venda</div>
                        <div class="card-body">
                            {{-- informações do produto --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row justify-content-between">
                                        <div class="col-sm-3">
                                            <label for="">Número de Itens</label>
                                            <h4>2</h4>
                                            
                                            <label>Desconto</label>
                                            <div class="input-group">
                                                <input type="number" value="0" class="form-control" placeholder="Desconto" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                              </div>
                                        </div>
                                       
                                        <div class="col-sm-8">
                                            <label for="">Total</label>
                                            <p id="valorTotal">R$ 20,00</p>
                                        </div>
                                    </div>                                     
                                </div>
                            </div>{{-- informações do produto --}}
                        </div>
                    </div>{{-- end Card Venda --}}
                </div>
            </div>{{-- Row Informações Venda --}}
            
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(function(){
        // Configuração do ajax com token csrf
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Busca de Cliente
        $('#formCliente').submit(function(event){
            event.preventDefault();
            getCliente($("#cpfCnpj").val());
        });
    });

    function getCliente(cpfCnpj){
        $.ajax({
            type: "POST",
            url: "/pedidos/getCliente/"+cpfCnpj,
            context: this,
            success: function(data){
                cliente = JSON.parse(data)
                $('#cliente_id').val(cliente[0].id);
                $('#nomeCliente').append(cliente[0].user.name);
                console.log(cliente[0].user.name);
            },
            error: function(error){
                console.log(error);
            }
        });
    }

</script>
@endsection