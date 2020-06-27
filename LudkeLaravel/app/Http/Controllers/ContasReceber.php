<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Pagamento;
use App\Pedido;

class ContasReceber extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Pedidos que possuem pagamentos com status 'aberto'
        $pedidos = Pedido::with(['pagamento'])->whereHas('pagamento', function($query){
            return $query->where('status','aberto');
        })->get();
        $listaPagamento = array(); //array para exibir na view
        foreach ($pedidos as $pedido) { //percorre os pedidos
            // inicializa os dados em um array aux
            $aux['idPedido'] = $pedido->id;
            $aux['nomeCliente'] = $pedido->cliente->user->name;
            $aux['valorTotal'] = $pedido->valorTotal;
            
            $totalPago = 0; //contador totalPago
            $menorDataVencimento = $pedido->pagamento[0]->dataVencimento;//menor data de vencimento

            // percorre os pagamentos do pedido
            foreach ($pedido->pagamento as $pagamento) {
                $vencimento = date($pagamento->dataVencimento);//pega data de vencimento
                $today = date('Y-m-d');
                
                // verifica se o pagamento ainda não foi pago
                if($pagamento->status == 'aberto'){

                    // verifica menor data de vencimento
                    if($vencimento < $menorDataVencimento){
                        $menorDataVencimento = $vencimento;
                        $aux['dataVencimento'] = $menorDataVencimento;
                    }else{
                        $aux['menorDataVencimento'] = $vencimento;
                    }

                }
                else{
                    $aux['dataVencimento'] = $vencimento; 
                }
                
                if($pagamento->status == 'fechado')
                    $totalPago += $pagamento->valorPago;
                
            }
            // dd($totalPago);
            $aux['totalPago'] = $totalPago;

            if($pedido->tipo == 'p')
                $aux['tipo'] = 'Pedido';
            elseif($pedido->tipo == 'v')
                $aux['tipo'] = 'Venda';
            else
                $aux['tipo'] = 'Venda Mobile';
            
            array_push($listaPagamento,$aux);
            
        }

        // dd($listaPagamento);
        return view('contasReceber',['listaPagamento'=>$listaPagamento]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $pedido = Pedido::with(['pagamento'])->find($id);
        return view('showContaReceber',['pedido'=>$pedido]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
