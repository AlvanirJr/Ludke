@extends('layouts.app')

@section('content')
<style></style>
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
                        <input class="form-control input-ludke" type="text" placeholder="Pesquisar" name="pesquisar">
                    </div>
                </div>
            </div><!-- end titulo-pagina -->
        </div><!-- end col-->
    </div><!-- end row-->


    <div class="row justify-content-center">
        <div class="col-sm-12">
            <table class="table table-hover table-responsive-sm">
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

                    @for($i = 0; $i < 10; $i++)
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
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
                    @endfor
                </tbody>
            </table> <!-- end table -->
        </div><!-- end col-->
    </div><!-- end row-->
</div>
@endsection