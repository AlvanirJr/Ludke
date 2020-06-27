@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="titulo-pagina">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="titulo-pagina-nome">
                                <h2>Contas a receber</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col-->
        </div><!-- end row-->

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <table id="tabelaCargos" class="table table-hover table-responsive-md">
                    <thead class="thead-primary">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Valor Total</th>
                        <th>Valor Pago</th>
                        <th>Data Vencimento</th>
                        <th>Tipo</th>
                        
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($listaPagamento as $pagamento)
                            <tr>
                                <td>{{$pagamento['idPedido']}}</td>
                                <td>{{$pagamento['nomeCliente']}}</td>
                                <td>R$ {{money_format('%i',$pagamento['valorTotal'])}}</td>
                                {{-- Calcula o total pago somando o pagamento dos pedidos que possui status fechado --}}
                                <td>R$ {{money_format('%i',$pagamento['totalPago'])}}</td>
                                <td> {{date('d/m/Y',strtotime($pagamento['dataVencimento']))}} </td>
                                <td> 
                                    {{$pagamento['tipo']}}
                                </td>
                                
                                <td>
                                    {{-- Contas a pagar --}}
                                    <a href={{route('contas.visualizar',['id' => $pagamento['idPedido']])}}>
                                        <img id="pagar" class="icone" src="{{asset('img/money-bill-wave-solid.svg')}}" >
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

@endsection

@section('javascript')
<script type="text/javascript">



</script>

@endsection
