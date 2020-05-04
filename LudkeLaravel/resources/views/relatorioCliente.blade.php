@section('date',$date)
@section('content')
@section('titulo','Relatório dos Clientes')
@extends('layouts.relatorios')

<table class="table table-bordered table-striped"  align="center" border="1">
    <thead class="table thead">
    <tr>
        <th>Nome Responsavel</th>
        <th>CPF</th>
        <th>Nome Reduzido</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clientes as $cliente)
        <tr class="linha">
            <td>{{$cliente->nomeResponsavel}}</td>
            <td >{{$cliente->cpfCnpj}}</td>
            <td>{{$cliente->nomeReduzido}}</td>

        </tr>
    @endforeach
    </tbody>
</table>

@stop
