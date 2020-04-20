<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\Produto;
use App\Funcionario;
use App\Cliente;
use App\ItensPedido;
use App\User;
use App\Status;

class VendaController extends Controller
{
    public function index(){
        return view('venda');
    }

    public function indexListarVendas()
    {
        $pedidos = Pedido::with(['status'])->
                            where('status_id',2)->
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


}
