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
                <th>Valor do Item</th>
				<th>Produto</th>

			</tr>
		</thead>
		<tbody>


        @foreach($itens as $iten)
				<tr class="linha">
                    <td>{{$iten->pesoFinal}} KG</td>
                    <td>{{$iten->valorReal = number_format($iten->valorReal, '2',',','.')}}</td>
                    <td>{{$iten->nomeProduto}}</td>
                </tr>
				@endforeach
		</tbody>
	</table>

    <h2 border=1  width=80% height=80% ALIGN=center >Valor Total: {{$soma = number_format($soma, '2',',','.')}} R$</h2>


@stop
