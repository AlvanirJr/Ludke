@section('date',$date)
@section('content')
@section('titulo','Relatório da Venda')
@extends('layouts.relatorios')

<div class="row justify-content-center">
    <div class="col-sm-12">
        <table id="tabelaPedidos" class="table table-borderless table-striped" style="width: 100vw">
            <thead class="thead-primary" style="background-color: #BF1A2C;color: white;">
            <tr style="height:20px">
                <th>Cpf</th>
                <th>Cliente</th>
                <th>Peso</th>
                <th>Valor</th>
                <th>Produto</th>
            </tr>
            </thead>
            <tbody>
            @foreach($itens as $item)
                <tr align="center">
                    <td>{{$clientes[0]->cpfCnpj}}</td>
                    <td >{{$clientes[0]->nomeReduzido}}</td>
                    <td>{{$item->pesoFinal}}</td>
                    <td>{{$item->valorReal = number_format($item->valorReal, '2',',','.').' R$'}}</td>
                    <td>{{$item->nomeProduto}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
