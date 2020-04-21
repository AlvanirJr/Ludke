<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Pedido;
use App\Produto;
use App\Funcionario;
use App\Cliente;
use App\ItensPedido;
use App\User;
use App\Status;
use App\Pagamento;

class VendaController extends Controller
{
    public function index(){
        return view('venda');
    }

    public function indexListarVendas()
    {
        $pedidos = Pedido::with(['status'])->
                            where('status_id',2)->
                            orwhere('status_id',3)->
                            orwhere('status_id',4)->
                            orwhere('status_id',5)->
                            orderBy('status_id')->
                            orderBy('dataEntrega')->paginate(25);
        return view('listarVendas',['pedidos'=>$pedidos]);
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

    public function concluirVenda($id){
        // dd($id);
        $pedido = Pedido::with(['itensPedidos'])->find($id);
        // dd($pedido);
        if(isset($pedido)){
            for($i = 0; $i< count($pedido->itensPedidos); $i++){
                $produto = Produto::find($pedido->itensPedidos[$i]->produto_id);
                $pedido->itensPedidos[$i]["precoProduto"] = $produto->preco;
            }
            $cliente = Cliente::with('user')->find($pedido->cliente_id);
            $funcionario = Funcionario::with('user')->find($pedido->funcionario_id);
            
            // $pedido["valorProduto"]= $produto->preco;
            $pedido["nomeCliente"] = $cliente->user->name;
            $pedido["nomeFuncionario"] = $funcionario->user->name;
            // $pedido["dataEntrega"] = new DateTime($pedido->dataEntrega);
            
            return view('finalizarVenda')->with(["pedido"=>$pedido]);
        }
    }
    function calcularDescontosItens($itens, $descontos){
        $itensComDesconto = [];
        // dd();
        for($i = 0; $i < count($itens); $i++){
            $itensComDesconto[$i] = floatval($itens[$i]->valorReal) - (floatval($itens[$i]->valorReal) * ($descontos[$i] / 100));
        }
        return $itensComDesconto;
    }
    
    public function concluirVendaPagamento(Request $request){
        // dd($request->all());
        $pedido = Pedido::with(['cliente','funcionario'])->find($request->input('pedido_id'));
        $descontos = $request->input('desconto');
        
        if(isset($pedido)){
            $itensPedido = ItensPedido::where('pedido_id',$pedido->id)->get();

            $itensComDesconto = self::calcularDescontosItens($itensPedido, $descontos);

            // dd($descontos[0]);
            $valorFinalDoPedido = 0.0;
            for($i = 0; $i < count($itensPedido); $i++){

                $itensPedido[$i]->descontoPorcentagem = floatval($descontos[$i]);
                $itensPedido[$i]->valorComDesconto = floatval($itensComDesconto[$i]);
                $itensPedido[$i]->save();
                $valorFinalDoPedido += floatval($itensComDesconto[$i]);
            }
            $pedido->valorTotal = $valorFinalDoPedido;
            $status = Status::where('status','PAGO PARCIALMENTE')->first();
            $pedido->status_id = $status->id;
            $pedido->save();
            
            // dd($itensPedido);
            

        }

        return view('pagamento',['pedido'=>$pedido]);
    }

    // Calcula o desconto aplicado em cima do pedido e retorna o valor com o desconto
    public function calcularDescontoPagamento($valorTotal, $desconto){
        $valorDesconto = $valorTotal - ($valorTotal * ($desconto/100));
        return $valorDesconto;
    }
    public function pagamento(Request $request){
        // $request->validate([
        //     'valorTotalPagamento'=> 'required|numeric',
        //     'dataVencimento' => 'required|string|date',
        //     'dataPagamento' => 'required|string|date',
        //     'statusPagamento' => 'required|string|max:255',
        //     'valorPago' => 'required|min:0',
        //     'descontoPagamento' => 'required|min:0',
        //     'obs' => 'nullable|string|max:255',
        //     ]);
        $pedido = Pedido::find($request->input('pedido_id'));
        
        // Calcula o valor com o desconto e salva esse valor em $pedido->valorTotal
        $valorDesconto = $this->calcularDescontoPagamento(floatval($pedido->valorTotal),floatval($request->input('descontoPagamento')));
        $pedido->valorTotal = $valorDesconto;
        
        $pagamento = new Pagamento();
        $pagamento->dataVencimento = $request->input('dataVencimento');
        $pagamento->dataPagamento = $request->input('dataPagamento');
        $pagamento->obs = $request->input('obs');
        $pagamento->descontoPagamento = $request->input('descontoPagamento');

        $pagamento->valorTotalPagamento = $request->input('valorTotalPagamento');
        $pagamento->valorPago = $request->input('valorPago');
        $pagamento->status = $request->input('statusPagamento');
        $pagamento->funcionario_id = $request->input('funcionario_id');
        $pagamento->pedido_id = $request->input('pedido_id');

        // se o valor pago for menor que o valor total do pedido, efetua o pagamento
        if($request->input('valorPago') < $pedido->valorTotal){
            // Salva o pagamento
            $pagamento->save();
            
            // Caso o valor pago seja menor que o valor total do pedido, o status dela permanece PAGO PARCIALMENTE
            $status = Status::where('status','PAGO PARCIALMENTE')->first();
            $pedido->status_id = $status->id;
            $pedido->save(); //Salva o pedido

            $pedidos = Pedido::with(['status'])->
                            where('status_id',2)->
                            orwhere('status_id',3)->
                            orwhere('status_id',4)->
                            orwhere('status_id',5)->
                            orderBy('status_id')->
                            orderBy('dataEntrega')->paginate(25);
            return view('listarVendas',['pedidos'=>$pedidos]);
        }
        if($request->input('valorPago') == $pedido->valorTotal){
            // Salva o pagamento
            $pagamento->save();
            
            // Caso o valor pago seja menor que o valor total do pedido, o status dela permanece PAGO TOTALMENTE
            $status = Status::where('status','PAGO TOTALMENTE')->first();
            $pedido->status_id = $status->id;
            $pedido->save(); //Salva o pedido

            $pedidos = Pedido::with(['status'])->
                            where('status_id',2)->
                            orwhere('status_id',3)->
                            orwhere('status_id',4)->
                            orwhere('status_id',5)->
                            orderBy('status_id')->
                            orderBy('dataEntrega')->paginate(25);
            return view('listarVendas',['pedidos'=>$pedidos]);
        }
        else{
            return view('finalizarVenda')->with(["pedido"=>$pedido,"sucess"=>false]);
        }

        
        
        
        
        
    }

}
