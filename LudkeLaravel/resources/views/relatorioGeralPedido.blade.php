@section('date',$date)
@section('content')
@section('titulo','Relatório dos Pedidos')
@extends('layouts.relatorios')

<div class="row justify-content-center">
    <div class="col-sm-12">
        <table id="tabelaClientes" class="table table-borderless table-striped" style="width: 100vw">
            <thead class="thead-primary" style="background-color: #BF1A2C;color: white;">
            <tr style="height:20px">
                <th>ID</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Data de Entrega</th>
                <th>Valor</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pedidos as $pedido)
                <tr align="center">
                    <td>{{$pedido->id}}</td>
                    <td >{{$pedido->cliente->nomeReduzido}}</td>
                    <td>{{$pedido->funcionario->user->name}}</td>
                    <td>{{$pedido->dataEntrega}}</td>
                    <td>{{$pedido->valorTotal = number_format($pedido->valorTotal, '2',',','.').' R$'}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
