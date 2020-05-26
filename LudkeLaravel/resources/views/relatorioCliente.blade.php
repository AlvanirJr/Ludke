@section('date',$date)
@section('content')
@section('titulo','Relatório de Clientes')
@extends('layouts.relatorios')

<div class="row justify-content-center">
    <div class="col-sm-12">
        <table id="tabelaClientes" class="table table-borderless table-striped" style="width: 100vw">
            <thead class="thead-primary" style="background-color: #BF1A2C;color: white;">
            <tr style="height:20px">
                <th>Código</th>
                <th>Nome</th>
                <th>Nome Reduzido</th>
                <th>Nome Responsável</th>
                <th>Cidade</th>
                <th>Func. Resp. </th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr align="center">
                    <td>{{$cliente->id}}</td>
                    <td>{{$cliente->user->name}}</td>
                    <td>{{$cliente->nomeReduzido}}</td>
                    <td>{{$cliente->nomeResponsavel}}</td>
                    <td>{{$cliente->user->endereco->cidade}}</td>
                    <td>{{$cliente->funcionario->user->name}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <table  id="tabelaClientes" class="table table-borderless table-striped" style="width: 100vw">
            <thead class="thead-primary" style="background-color: #BF1A2C;color: white;">
            <tr style="height:20px">
                <th>Total de Clientes</th>
            </tr>
            </thead>
            <tr align="center">
                <td>{{$count}}</td>
            </tr>
        </table>
    </div>
</div>

@stop
