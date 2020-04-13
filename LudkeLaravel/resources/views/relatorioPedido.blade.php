@section('date',$date)
@section('content')
@section('titulo','Relatório Pedido')
@extends('layouts.relatorios')

<table class="table table-bordered table-striped"  align="center" border="1">
    <thead class="table thead">
    <tr>
        <th>CPF</th>
        <th>Cliente</th>
    </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
            <tr class="linha">
                <td >{{$cliente->cpfCnpj}}</td>
                <td>{{$cliente->nomeResponsavel}}</td>
            </tr>
        @endforeach
    </tbody>
</table>


    <table  border=1  width=80% height=80% ALIGN=center style="margin-top:10px" >
 		<thead class="table thead">
			<tr >
				<th>Peso</th>
                <th>Valor Item</th>
				<th>Produto</th>
                <th>Valor Total</th>


			</tr>
		</thead>
		<tbody>


        @foreach($itens as $iten)
				<tr class="linha">
                    <td>{{$iten->pesoFinal}}</td>
                    <td>{{$iten->valorReal}}</td>
                    <td>{{$iten->nomeProduto}}</td>
                    <td>{{$soma}}</td>

                </tr>
				@endforeach
		</tbody>
	</table>


@stop
