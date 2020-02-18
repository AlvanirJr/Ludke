<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cliente;
use App\Produto;
use App\User;
use App\ItensPedido;
use App\Pedido;
class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pedido');
    }

    public function indexListarPedidos(){
        return view('listarPedido');
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

    // retorna o cliente através do cpj ou cnpj
    public function getCliente(Request $request){
        $cliente = User::where('name','like','%'.$request->input('nome').'%')->with('cliente')->get();
        if(isset($cliente)){
            // dd($cliente);
            return json_encode($cliente);
        }
        else{
            return resonse('Cliente não encontrado', 404);
        }
    }

    public function getProdutos(Request $request){
        $produtos = Produto::where('nome','like','%'.$request->input('nome').'%')->get();
        // dd($produtos);
        if(isset($produtos)){
            return json_encode($produtos);
        }
        else{
            return response('Produto não encontrado', 404);
        }
    }
    function calcularTotal($listaProdutos){
        $valorTotal = 0;
        foreach($listaProdutos as $item){
            $produto = Produto::find($item[0]['produto_id']);
            if(isset($produto)){
                $valorTotal += $produto->preco * $item[0]['peso']; 
            }
        }
        return $valorTotal;
    }
    public function finalizarPedido(Request $request){

        $cliente = Cliente::find($request->input('cliente_id'));
        
        // valor total sem desconto
        $valorTotal = 0;
        $desconto = 0;
        foreach($request->input('listaProdutos') as $item){
            $produto = Produto::find($item[0]['produto_id']);
            if(isset($produto)){
                $valorTotal += $produto->preco * $item[0]['peso']; 
            }
        }
        $pedido = new Pedido();
        // valcula o desconto no valor total
        $valorTotal = $valorTotal - floatval($request->input('valorDesconto'));
        $pedido->valorTotal = $valorTotal;
        
        $pedido->formaPagamento = "";
        $pedido->desconto = floatval($request->input('valorDesconto'));
        $pedido->dataEntrega = $request->input('dataEntrega');
        $pedido->status = "Aberto";
        $pedido->cliente_id = $cliente->id;
        $pedido->funcionario_id = Auth::user()->id; //salvando o user_id do funcionario
        
        $pedido->save(); // salva o pedido
        // dd($pedido);

        foreach($request->input('listaProdutos') as $item){
            
            $itemPedido = new ItensPedido();
            $produto = Produto::find($item[0]['produto_id']);
            if(isset($produto)){
                $itemPedido->pesoSolicitado = $item[0]['peso'];
                $itemPedido->pesoFinal = $item[0]['peso'];
                $itemPedido->valorReal = $produto->preco * $item[0]['peso'];
                $itemPedido->nomeProduto = $produto->nome;
                $itemPedido->produto_id = $produto->id;
                $itemPedido->pedido_id = $pedido->id;

                $itemPedido->save();
            }
        }

        return json_encode(['success'=> true,'msg'=>'Pedido cadastrado com sucesso']);
    }

    public function getPedidos(){
        $pedidos = Pedido::with(['itensPedidos'])->get();

        return json_encode($pedidos);

    }
}
