@section('date',$date)
@section('content')
@section('titulo','Relatório de Clientes')
@extends('layouts.relatorios')

<div class="row justify-content-center">
    <div class="col-sm-12">
        <table id="tabelaClientes" class="table table-borderless" style="width: 100vw">
            <thead class="thead-primary" style="background-color: #BF1A2C;color: white;">
            <tr style="height:20px">
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Telefone</th>
                <th>Endereço</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr align="center">
                    <td>{{$cliente->user->name}}</td>
                    <td >{{$cliente->cpfCnpj}}</td>
                    <td>{{$cliente->user->telefone->celular}}</td>
                    <td>
                        {{$cliente->user->endereco->rua}}, 
                        {{$cliente->user->endereco->numero}}, 
                        {{$cliente->user->endereco->cidade}} -  
                        {{$cliente->user->endereco->uf}}
                    
                    </td>
        
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
