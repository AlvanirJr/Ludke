@section('date',$date)
@section('content')
@section('titulo','Relatório Pedido')
@extends('layouts.relatorios')


    <table class="table table-bordered table-striped">
 		<thead class="table thead">
			<tr>
				<th>Peso</th>
				<th>Final</th>
				<th>REal</th>
				<th>Produto</th>
			</tr>
		</thead>
		<tbody>

			@foreach($itens as $iten)
				<tr class="linha">
					<td>{{$iten->pesoSolicitado}}</td>
						<td>{{$iten->pesoFinal}}</td>
							<td>{{$iten->valorReal}}</td>
							<td>{{$iten->nomeProduto}}	</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop