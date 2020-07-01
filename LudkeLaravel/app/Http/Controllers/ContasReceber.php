<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Pagamento;
use App\Pedido;

class ContasReceber extends Controller
{
    public function index($idPedido = null){
        if(isset($idPedido)){
            $pagamentosAbertos = Pagamento::where('pedido_id',$idPedido)->where('status','aberto')->orderBy('dataVencimento')->paginate(25);
            $pagamentosFechados = Pagamento::where('pedido_id',$idPedido)->where('status','fechado')->orderBy('dataVencimento')->paginate(25);

            $listarTodos = true;
        }else{
            $pagamentosAbertos = Pagamento::where('status','aberto')->orderBy('dataVencimento')->paginate(25);
            $pagamentosFechados = Pagamento::where('status','fechado')->orderBy('dataVencimento')->paginate(25);
            $listarTodos = false;
        }
        $infoMensal = self::infoMensal();
        
        return view('contasReceber',['pagamentosAbertos'=>$pagamentosAbertos,'pagamentosFechados'=>$pagamentosFechados,'infoMensal' => $infoMensal,'listarTodos' => $listarTodos]);
    }

    public function infoMensal(){
        
        
        $dataHoje = strtotime(date('Y-m-d'));
        $inicioMes = date('Y-m-d',mktime(0,0,0, date('m'), 1, date('Y'))); // inicio do mês
        $finalMes = date("Y-m-t"); // final do Mês 

        // retorna todos os pagamentos
        //retorna 
        $pagamentosMensal = Pagamento::whereDate('dataVencimento','>=',$inicioMes)
            ->whereDate('dataVencimento','<=',$finalMes)->get();


        $totalPagamentosAberto = 0;
        $totalPagamentosFechados = 0;
        $totalPagamentosVencidos = 0;
        $totalPagamentosAguardando = 0;
        
        
        $totalValorRecebido = 0;
        $totalValorAguardandoPagamento = 0;

        $contValorPago = 0;
        $contValorAguardandoPagamento = 0;
        foreach ($pagamentosMensal as $pagamento) {

            $contValorPago += $pagamento->valorPago;
            $contValorAguardandoPagamento += $pagamento->valorTotalPagamento - ($pagamento->descontoPagamento / 100);

            // conta Pagamentos abertos e fechados
            if($pagamento->status == 'aberto'){
                $totalPagamentosAberto+=1;
            }
            else{
                $totalPagamentosFechados+=1;
            }

            // //Conta pagamentos vencidos e aguardando

            // if(date('Y-m-d',strtotime($pagamento->dataVencimento)) < $dataHoje && $pagamento->valorPago == 0){
            //     $totalPagamentosVencidos += 1;
            // }
            // if(date('Y-m-d',strtotime($pagamento->dataVencimento)) >= $dataHoje && $pagamento->valorPago == 0){
                
            //     $totalPagamentosAguardando += 1;
            // }

        }

        // configura array infoGeral
        $infoGeral['totalPagamentos'] = count($pagamentosMensal);
        $infoGeral['valorTotalPago'] = $contValorPago ;
        $infoGeral['valorTotalAguardando'] = $contValorAguardandoPagamento - $contValorPago;
        $infoGeral['totalPagamentosPagos'] = $totalPagamentosFechados;
        $infoGeral['totalPagamentosVencidos'] = $totalPagamentosVencidos ;
        $infoGeral['totalPagamentosAguardando'] = $totalPagamentosAguardando ;


        // dd($pagamentosMensal, $infoGeral,$inicioMes,$finalMes, $dataHoje);
        return $infoGeral;
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
        $pagamento = Pagamento::find($request['formIdPagamento']);
        $pagamento->valorPago = $request['formValorPago'];
        $pagamento->dataPagamento = date('Y-m-d');
        $pagamento->status = "fechado";
        $pagamento->save();
        // dd($request->all(),$pagamento);
        return redirect()->route('contas.receber');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pagamento = Pagamento::find($id);
        
        $pagamento->pedido->cliente->user;//carrega as relações do pagamento        

        return json_encode($pagamento);
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