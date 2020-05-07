<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cliente;
use App\Produto;
use App\User;
use App\ItensPedido;
use App\Pedido;
use App\Funcionario;
use App\Status;
use App\Pagamento;
use App\Cargo;
use App\FormaPagamento;

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
        // Busca os pedidos com status SOLICITADO e PESADO
        $pedidos = Pedido::with(['status'])->
                                where('status_id',1)->      //SOLICITADO
                                orwhere('status_id',2)->    //PESADO
                                orwhere('status_id',3)->    //ENTREGUE
                                orwhere('status_id',4)->    //PAGO PARCIALMENTE
                                orwhere('status_id',5)->    //PAGO TOTALMENTE
                                orderBy('status_id')->
                                orderBy('dataEntrega')->paginate(25);
        // dd($pedidos);
        return view('listarPedido',['pedidos'=>$pedidos]);
    }

    public function indexPagamento($id){
        // Pedido
        $pedido = Pedido::with(['cliente'])->find($id);

        // Itens do Pedido
        $itensPedido = ItensPedido::where('pedido_id',$pedido->id)->get();
        
        $valorTotalDoPagamento = 0;
        $valorDoDesconto = 0;

        foreach ($itensPedido as $item) {
            $valorTotalDoPagamento += floatval($item->valorComDesconto);
            $valorDoDesconto += floatval($item->valorReal) - floatval($item->valorComDesconto);
        }

        //------------DEBUG--------------------------
        // dd($pedido,$itensPedido, $valorTotalDoPagamento,$valorDoDesconto);
        $entregador_id = Cargo::where('nome','ENTREGADOR')->pluck('id')->first();
        $entregadores = Funcionario::with(['user'])->where('id',$pedido->funcionario_id)->
                                        orwhere('cargo_id',$entregador_id)->get();
        $formasPagamento = FormaPagamento::all();
        return view('pagamento',
            [
                'pedido'=>$pedido,
                'valorTotalDoPagamento'=>$valorTotalDoPagamento,
                'valorDoDesconto'=>$valorDoDesconto,
                'entregadores'=>$entregadores,
                'formasPagamento'=>$formasPagamento,
            ]);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedido = Pedido::with(['itensPedidos'])->find($id);
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

            
            return view('editarPedido')->with(["pedido"=>$pedido]);
        }
        
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
        
        $pedido = Pedido::find($request->input('id'));
        $valorTotal = floatval($pedido->valorTotal);
        
        // Lista com novos pedidos Adicionados
        $listaProdutos = $request->input('listaProdutos');
        if(isset($listaProdutos)){
            foreach($request->input('listaProdutos') as $item){
                $itemPedido = new ItensPedido();
                $produto = Produto::find($item['produto_id']);
                if(isset($produto)){
                    $itemPedido->pesoSolicitado = floatval($item['peso']);
                    $itemPedido->pesoFinal = floatval($item['peso']);
                    $itemPedido->valorReal = floatval($produto->preco * $item['peso']);
                    $itemPedido->nomeProduto = $produto->nome;
                    $itemPedido->produto_id = $produto->id;
                    $itemPedido->pedido_id = $pedido->id;
    
                    $itemPedido->save();
    
                    $valorTotal += $produto->preco * floatval($item['peso']); //soma ao valor total
                }
            }

        }

        // forma de pagamento só é definida na conclusão do pedido
        
        $pedido->dataEntrega = $request->input('dataEntrega');
        // $pedido->status = "ABERTO";
        
        
        
        // deleta itens
        $deletar = $request->input('deletar');
        // dd($deletar);
        if(isset($deletar)){
            for($i = 0; $i < sizeof($deletar); $i++){
                $itemDeletado = ItensPedido::find(intval($deletar[$i]['id']));
                if(isset($itemDeletado)){
                    
                    $valorTotal -= floatval($itemDeletado['valorReal']);
                    // dd($valorTotal);
                    $itemDeletado->delete();
                }
            }
        }
        $itens_pedidos = $request->input('itens_pedidos');
        if(isset($itens_pedidos)){
            foreach($request->input('itens_pedidos') as $item){
                $itemPedido = ItensPedido::find($item['id']);
                
                $produto = Produto::find($item['produto_id']);
                
                if(isset($produto)){
                    // dd(floatVal($item['pesoSolicitado']));
                    // $valorTotal += $produto->preco * floatVal($item['pesoSolicitado']); 
                    // dd($valorTotal);
                    $itemPedido->pesoSolicitado = floatval($item['pesoSolicitado']);
                    
                    $itemPedido->valorReal = $produto->preco * floatVal($item['pesoSolicitado']);
    
                    $itemPedido->save();
                }
            }
        }
        
        // Salva o valor total

        
        $pedido->valorTotal = $valorTotal;
        // dd($valorTotal);
        $pedido->save(); // salva o pedido
        return route('listarPedidos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $pedido = Pedido::find($id);
        
        if(isset($pedido)){
            $itensPedido = ItensPedido::where("pedido_id",$id)->delete();
            $pagamento = Pagamento::where('pedido_id',$id)->delete();
            $pedido->delete();
            return response("Pedido Excluído",200);

        }else{
            return response('Pedido não encontrado',404);
        }
    }
    /**
     * Função que carrega os dados do pedido na view para salvar o peso dos itens
     * @param $id
     * @return view finalizarPedido
     */
    public function pesarPedido($id){
        $pedido = Pedido::with(['itensPedidos'])->find($id);
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
            
            return view('finalizarPedido')->with(["pedido"=>$pedido]);
        }
        
    }
    /**
     * Função busca os dados referente ao pedido e retorna para tela concluirPedido
     * @param $id
     * @return view concluirPedido
     */
    public function concluirPedido($id){
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
            
            return view('concluirPedido')->with(["pedido"=>$pedido]);
        }
    }

    /**
     * Função que calcula os descontos nos itens e retorna um array com o preço dos itens após
     * o desconto ser aplicado
     * @param Array $itens
     * @param Array $descontos
     * @return Array $itensComDesconto
     */
    function itensComDesconto($itens, $descontos){
        $itensComDesconto = [];
        for($i = 0; $i < count($itens); $i++){
            $itensComDesconto[$i] = floatval($itens[$i]->valorReal) - (floatval($itens[$i]->valorReal) * ($descontos[$i] / 100));
        }
        return $itensComDesconto;
    }
    /**
     * Salva os dados dos descontos referente aos itens e salva informações do pedido
     * @param Request
     * @return view pagamentos
     */
    public function concluirPedidoComDescontoNosItens(Request $request){
        
        // pedido
        $pedido = Pedido::find($request['pedido_id']);
        // array com a porcentagem dos descontos referente aos itens 
        $descontos = $request['desconto'];
        // array com os itens do pedido
        $itensPedido = ItensPedido::where('pedido_id',$request['pedido_id'])->get();
        // array contendo os preços com os descontos calculados
        $itensComDesconto = $this->itensComDesconto($itensPedido, $descontos);        
        
        
        // Se o pedido tiver o status PESADO
        if($pedido->status->status == "PESADO"){
            /**
             * Percorre $itensPedido, $descontos e $itensComDesconto 
             * e salva o descontoPorcentagem e valorComDesconto
             */
            if(count($itensPedido) === count($itensComDesconto)){
                for($i = 0; $i <= count($itensPedido) - 1; $i++ ){
                    $itensPedido[$i]->descontoPorcentagem = $descontos[$i];
                    $itensPedido[$i]->valorComDesconto = $itensComDesconto[$i];
                    $itensPedido[$i]->save();
                }
            }
            $pedido->save();
        }
        
        // ------------------------ DEBUG ------------------------
        // dd($request->all(),$pedido->status->status,$itensPedido,$itensComDesconto);
        // return view('pagamento',['pedido'=>$pedido]);

        return redirect('/pedidos/pagamento/'.$pedido->id);

    }

    /**
     * Função que calcula o desconto aplicado em cada forma de pagamento
     * 
     * @param $valorTotalPagamento
     * @param $descontoPagamento
     * @return $valorPago
     */
    function descontoFormaPagamento($valorTotalPagamento, $descontoPagamento){
        $valorPago = 0.0;
        $valorPago = floatval($valorTotalPagamento) - (floatval($valorTotalPagamento) * ($descontoPagamento / 100));
        return $valorPago;
    }
    /**
     * Função que registra o pagamento efetuado
     * @param Request
     * @return void
     */
    public function pagamento(Request $request){
        $pedido = Pedido::find($request['pedido_id']);
        
        // -------------DEBUG----------------
        // dd($request->all(),$pedido,Auth::user()->funcionario->id);
        
        $pedido->entregador_id = $request['entregador_id'];
        $status_id = Status::where('status','PAGO PARCIALMENTE')->pluck('id')->first();
        $pedido->status_id = $status_id;
        $pedido->save();
        
        //Salva cada forma de pagamento
        for($i = 0; $i < count($request['formaPagamento']); $i++){
            $pagamento = new Pagamento();
            $pagamento->dataVencimento = $request['dataVencimento'][$i];
            $pagamento->dataPagamento = $request['dataPagamento'][$i];
            $pagamento->obs = $request['obs'][$i];
            $pagamento->descontoPagamento = floatval($request['descontoPagamento'][$i]);//porcentagem do pagamento
            $pagamento->valorTotalPagamento = floatval($request['valorTotalPagamento'][$i]);//valor sem desconto aplicado
            $pagamento->valorPago = self::descontoFormaPagamento(floatval($request['valorTotalPagamento'][$i]),floatval($request['descontoPagamento'][$i])); // valor com desconto aplicado
            $pagamento->formaPagamento_id = $request['formaPagamento'][$i];
            
            $pagamento->funcionario_id = Auth::user()->funcionario->id;
            $pagamento->pedido_id = $pedido->id;
            $pagamento->save();
        }

        return redirect()->route('listarPedidos');

    }


    // retorna o cliente através do cpj ou cnpj
    public function getCliente(Request $request){
        $user = User::with(['cliente'])->where('name','like','%'.$request->input('nome').'%')->get();
        $cliente = [];
        for($i = 0; $i < count($user); $i++){
            if($user[$i]->cliente != null){
                array_push($cliente,[
                    "name"=>$user[$i]->name,"cliente_id"=>$user[$i]->cliente->id
                    ]);
            }
        }        
        if(isset($cliente)){
            // dd($cliente);
            return json_encode($cliente);
        }
        else{
            return resonse('Cliente não encontrado', 404);
        }
    }
    
    public function buscaCliente($id){
        // dd($id);
        $c = Cliente::with(['user'])->find($id);
        // dd($cliente);
        $cliente['id'] = $c->id;
        $cliente['nome'] = $c->user->name;
        return json_encode($cliente);
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
        $pedido->valorTotal = $valorTotal;
        
        
        // $pedido->desconto = floatval($request->input('valorDesconto'));
        $pedido->dataEntrega = $request->input('dataEntrega');
        $status = Status::where('status','SOLICITADO')->first(); // Solicitado
        // dd($status->id);
        $pedido->status_id = $status->id;
        $pedido->cliente_id = $cliente->id;
        $funcionario = Funcionario::find(Auth::user()->id);
        $pedido->funcionario_id = $funcionario->id; //salvando o user_id do funcionario que está logado
        
        // dd($pedido);
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
        $pedidos = Pedido::with(['itensPedidos'])->orderBy('status_id')->orderBy('dataEntrega')->get();
        $size = sizeof($pedidos);
        for($i = 0; $i < $size; $i++){
            $cliente = Cliente::with('user')->find($pedidos[$i]->cliente_id);
            $funcionario = Funcionario::with('user')->find($pedidos[$i]->funcionario_id);
            
            $pedidos[$i]["nomeCliente"] = $cliente->user->name;
            $pedidos[$i]["nomeFuncionario"] = $funcionario->user->name;
        }
        return json_encode($pedidos);

    }

    function calcularDescontosItens($itens, $descontos){
        $itensComDesconto = [];
        for($i = 0; $i < count($itens); $i++){
            $itensComDesconto[$i] = floatval($itens[$i]->valorReal) - (floatval($itens[$i]->valorReal) * ($descontos[$i] / 100));
        }
        return $itensComDesconto;
    }

    /**
     * Conclui a pesagem dos itens do pedido e salva os dados
     * 
     * @param $request
     * @return view listarPedidos
     */
    public function concluirPedidoPesoFinal(Request $request){
        // dd($request->all());
        $pedido = Pedido::with(['itensPedidos'])->find($request->input('pedido_id'));
        $valorTotal = 0;
        foreach($pedido->itensPedidos as $item){
            $validator = $request->validate([
                'pesoFinal'.$item->id => 'required',
            ]);
            
            $produto = Produto::find($item->produto_id);
            $item->pesoFinal = floatval($request->input('pesoFinal'.$item->id));
            $item->valorReal = floatval($item->pesoFinal * $produto->preco);
            $valorTotal += floatval($item->valorReal);
            $item->save();
        }
        $pedido->valorTotal = $valorTotal;
        $status = Status::where('status','PESADO')->first(); //
        $pedido->status_id = $status->id;

        // dd($pedido);
        $pedido->save();

        // Busca os pedidos com status SOLICITADO e PESADO
        $pedidos = Pedido::with(['status'])->
                                where('status_id',1)->
                                orwhere('status_id',2)->
                                orderBy('status_id')->
                                orderBy('dataEntrega')->paginate(25);
        return view('listarPedido',['pedidos'=>$pedidos]);
    }


    // Filtra Pedido
    public function filtrarPedido(Request $request, Pedido $pedido){
        $filtro = $request->all();
        // dd($filtro);
        
        $pedidos = $pedido->filtro($filtro,25);

        return view('listarPedido',['pedidos'=>$pedidos,'filtro'=>$filtro,'achou'=> true]);
        // dd($pedidos);

    }
}
