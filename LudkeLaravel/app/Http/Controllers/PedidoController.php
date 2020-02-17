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

    public function finalizarPedido(Request $request){
        // dd($request);
        $user = User::find($request->input('cliente_id'));

        


        $pedido = new Pedido();
        $pedido->formaPagamento = "";
        $pedido->desconto = $request->input('desconto');
        $pedido->dataEntrega = $request->input('dataEntrega');
        $pedido->valorTotal = $request->input('total');
        $pedido->cliente_id = $user->cliente->id;
        $pedido->funcionario_id = Auth::user()->id; //salvando o user_id do funcionario
        
        $pedido->save();

        foreach($request->input('listaProdutos') as $item){
            
            $itemPedido = new ItensPedido();
            $produto = Produto::find($item['produto_id']);
            if(isset($produto)){
                $itemPedido->pesoSolicitado = $item['peso'];
                $itemPedido->pesoFinal = $item['peso'];
                $itemPedido->valorReal = $produto->preco * $item['peso'];
                $itemPedido->produto_id = $produto->id;
                $itemPedido->pedido_id = $pedido->id;

                $itemPedido->save();
            }
        }

        return json_encode(['success'=> true,'msg'=>'Pedido cadastrado com sucesso']);
    }
}
