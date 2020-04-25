<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Pedido;
use App\Produto;
use App\Funcionario;
use App\Cliente;
use App\ItensPedido;
use App\User;
use App\Status;
use App\Pagamento;
use App\Cargo;

class VendaController extends Controller
{
    public function index(){
        return view('venda');
    }

    public function indexListarVendas($statusVenda=null)
    {
        // statusVenda é retornado pela rota se uma venda foi cadastrada com sucesso
        if(isset($statusVenda)){
            $pedidos = Pedido::with(['status','pagamento'])->
                                orderby('status_id')->
                                paginate(25);
            return view('listarVendas',['pedidos'=>$pedidos,'statusVenda'=>$statusVenda]);
        }
        else{
            $pedidos = Pedido::with(['status','pagamento'])->
                                orderby('status_id')->
                                paginate(25);
            return view('listarVendas',['pedidos'=>$pedidos]);
        }
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
        for($i = 0; $i < count($itens); $i++){
            $itensComDesconto[$i] = floatval($itens[$i]->valorReal) - (floatval($itens[$i]->valorReal) * ($descontos[$i] / 100));
        }
        return $itensComDesconto;
    }
    
    public function concluirVendaPagamento(Request $request){
        
        // Busca o pedido no banco
        $pedido = Pedido::with(['cliente','funcionario'])->find($request->input('pedido_id'));
        // Guarda o array contendo os descontos de cada item do pedido
        $descontos = $request->input('desconto');
        // busca itens do pedido
        $itensPedido = ItensPedido::where('pedido_id',$pedido->id)->get();
        // calcula o desconto dos itens
        $itensComDesconto = self::calcularDescontosItens($itensPedido, $descontos);
        // valor do pedido com dos descontos dos itens para ser exibido na view
        $valorPedidoComDesconto = 0;

        // Seleciona o id do cargo entregador
        $entregador_id = Cargo::where('nome','VENDEDOR(A)')->pluck('id')->first(); 
        // Seleciona os entregadores para o pedido
        $entregadores = Funcionario::with(['user'])->where('cargo_id',$entregador_id)->get();
        
        foreach($itensComDesconto as $desc){
            $valorPedidoComDesconto += $desc;
        }

        // Se o status do pedido for PESADO
        if($pedido->status_id== 2){
            $valorDoDescontoNosItens = 0; //Valor Dos descontos aplicados nos ítens do pedido
            for($i = 0; $i < count($itensPedido); $i++){
                $valorDoDescontoNosItens += $itensPedido[$i]->valorReal - $itensComDesconto[$i];
            }
            // dd($valorDoDescontoNosItens);
    
            // retorna para view de pagamentos com o pedido e os descontos dos itens
            return view('pagamento',[
                                    'pedido'=>$pedido,
                                    'descontos'=>$descontos,
                                    'valorPedidoComDesconto'=> $valorPedidoComDesconto,
                                    'valorDoDescontoNoPedido' => $valorDoDescontoNosItens, //valor exibido na tela
                                    'entregadores' => $entregadores,
                                    ]);
        }
        else{
            // Seleciona pagamento
            $pagamento = Pagamento::where('pedido_id',$pedido->id)->first();
            // dd($pagamento);
            
            $valorTotalPagamentoMenosValorPago = $pagamento->valorTotalPagamento - $pagamento->valorPago;
            
            // Calcula o desconto no valor do pagamento ((Valor total - descontoItens%) - valorPagamentoComDesconto%)
            $valorDoDescontoNoPedido = $pedido->valorTotal - $pagamento->valorTotalPagamento;
            // retorna para view de pagamentos com o pedido e os descontos dos itens
            return view('pagamento',[
                                    'pedido'=>$pedido,
                                    'descontos'=>$descontos, // array com os descontos dos itens
                                    'valorPedidoComDesconto'=> $valorPedidoComDesconto, //valor para ser usado no pagamento
                                    'pagamento'=>$pagamento,
                                    'valorRestantePagamento' => $valorTotalPagamentoMenosValorPago, //Valor exibido na tela
                                    'valorDoDescontoNoPedido' => $valorDoDescontoNoPedido, //valor exibido na tela
                                    'entregadores' => $entregadores,
                                    ]);
        }
    }

    /**
     * Calcula o desconto aplicado em cima do pedido e retorna um array
     * com os valores dos descontos 
     **/ 
    
    public function calcularvalorPagamentoComDesconto($valorTotal, $desconto){
        $valorDesconto = $valorTotal - ($valorTotal * ($desconto/100));
        return $valorDesconto;
    }

    /**
        * Faz o pagamento do pedido
        * Um pedido pode possuir 5 status diferentes:
        * 1 - SOLICITADO
        * 2 - PESADO
        * 3 - ENTREGUE
        * 4 - PAGO PARCIALMENTE
        * 5 - PAGO TOTALMENTE
        * 
        * Somente os pedidos com status 'PESADO' e 'PAGO PARCIALEMENTE' podem ser pagos
    */ 
    public function pagamento(Request $request){
        // dd($request->all());
        // Procura pedido referente ao pagamento no banco
        $pedido = Pedido::find($request->input('pedido_id')); 

        
        // Array contendo os descontos dos itens
        $descontoItens = $request->input('descontoItens');

        // Se o pedido for encontrado
        if(isset($pedido)){
            
            // Array contendo os itens do pedido
            $itensPedido = ItensPedido::where('pedido_id',$pedido->id)->get();
            // O pedido já foi pesado
            if($pedido->status->status == "PESADO"){
                // Entregador do Pedido
                if(isset($request['entregador_id'])){
                    $pedido->entregador_id = $request['entregador_id'];
                }
                // calcula o desconto nos itens e retorna um array com os descontos
                $arrayDescontoItens = self::calcularDescontosItens($itensPedido, $descontoItens);
                // contador para armazenar o valor total do desconto dos itens
                $descontoTotalItens = 0.0;
                // loop que calcula o desconto total nos itens
                for($i = 0; $i < count($itensPedido); $i++){
                    $itensPedido[$i]->descontoPorcentagem = floatval($descontoItens[$i]);
                    $itensPedido[$i]->valorComDesconto = floatval($arrayDescontoItens[$i]);
                    $itensPedido[$i]->save(); // Salva o DESCONTO e o VALOR COM DESCONTO no ítem
                    $descontoTotalItens += floatval($arrayDescontoItens[$i]);
                }
                // dd($descontoTotalItens);
                // Calcula o desconto no valor do pagamento ((Valor total - descontoItens%) - valorPagamentoComDesconto%)
                $valorPagamentoComDesconto = $this->calcularvalorPagamentoComDesconto(floatval($descontoTotalItens),floatval($request->input('descontoPagamento')));
                // dd($valorPagamentoComDesconto);
                // ------------------> DEBUG <----------------------
                // dd($valorPagamentoComDesconto, $request->all(),$pedido, $itensPedido);
                // ------------------> END DEBUG <----------------------

                // Cria novo obj pagamento
                $pagamento = new Pagamento();
                // Insere valores em Pagamento
                $pagamento->dataVencimento = $request['dataVencimento'];
                $pagamento->dataPagamento = $request['dataPagamento'];
                $pagamento->formaPagamento = $request['formaPagamento'];
                $pagamento->obs = $request['obs'];
                $pagamento->descontoPagamento = $request['descontoPagamento'];
                $pagamento->valorTotalPagamento = $valorPagamentoComDesconto;
                $pagamento->valorPago = $request['valorPago'];
                $pagamento->funcionario_id = $request['funcionario_id'];
                $pagamento->pedido_id = $pedido->id;

                

                // SALVA OS VALORES
                // Se o valor pago for menor ou igual ao valor total do pagamento
                //salva os objs
                if($pagamento->valorPago < $pagamento->valorTotalPagamento){
                    // Atualiza status do pedido
                    $status = Status::where('status','PAGO PARCIALMENTE')->first();
                    $pedido->status_id = $status->id;
                    $pedido->save();
                    // $itensPedido->save();
                    $pagamento->save();

                    // Retorna para tela de listagem de pedidos com msg de sucesso
                    $pedidos = Pedido::with(['status'])->
                                    where('status_id',2)->
                                    orwhere('status_id',3)->
                                    orwhere('status_id',4)->
                                    orwhere('status_id',5)->
                                    orderBy('status_id')->
                                    orderBy('dataEntrega')->paginate(25);
                    return view('listarVendas',['pedidos'=>$pedidos,'sucessoPagamento'=>'Pagamento finalizado com sucesso!']);
                }
                elseif($pagamento->valorPago == $pagamento->valorTotalPagamento){
                    // Atualiza status do pedido
                    $status = Status::where('status','PAGO TOTALMENTE')->first();
                    $pedido->status_id = $status->id;
                    $pedido->save();
                    // $itensPedido->save();
                    $pagamento->save();

                    // Retorna para tela de listagem de pedidos com msg de sucesso
                    $pedidos = Pedido::with(['status'])->
                                    where('status_id',2)->
                                    orwhere('status_id',3)->
                                    orwhere('status_id',4)->
                                    orwhere('status_id',5)->
                                    orderBy('status_id')->
                                    orderBy('dataEntrega')->paginate(25);
                    return view('listarVendas',['pedidos'=>$pedidos,'sucessoPagamento'=>'Pagamento finalizado com sucesso!']);
                }
                else{ //senão, retorna para listagem de vendas com um alerta de erro
                    $pedidos = Pedido::with(['status'])->
                                    where('status_id',2)->
                                    orwhere('status_id',3)->
                                    orwhere('status_id',4)->
                                    orwhere('status_id',5)->
                                    orderBy('status_id')->
                                    orderBy('dataEntrega')->paginate(25);
                return view('listarVendas',['pedidos'=>$pedidos,'erroPagamento'=>'Não é possível salvar o valor pago maior que o valor total do pagamento!']);
                }

            }
            // O pedido já foi pago parciamente
            elseif($pedido->status->status == "PAGO PARCIALMENTE"){
                // Entregador do Pedido
                if(isset($request['entregador_id'])){
                    $pedido->entregador_id = $request['entregador_id'];
                }
                $pagamento = Pagamento::where('pedido_id',$pedido->id)->first();

                $pagamento->dataVencimento = $request['dataVencimento'];
                $pagamento->dataPagamento = $request['dataPagamento'];
                $pagamento->formaPagamento = $request['formaPagamento'];
                $pagamento->obs = $request['obs'];
                
                
                $pagamento->valorPago = $pagamento->valorPago + $request['valorPago'];
                $pagamento->funcionario_id = $request['funcionario_id'];

                // Se o valor pago for menor que o valor restante do pagamento
                if($request['valorPago'] < $request['valorRestantePagamento']){
                    // dd($request->all(),$pedido,$pagamento);                
                    $status = Status::where('status','PAGO PARCIALMENTE')->first();
                    $pedido->status_id = $status->id;
                    $pedido->save();
                    // $itensPedido->save();
                    $pagamento->save();

                    // Retorna para tela de listagem de pedidos com msg de sucesso
                    $pedidos = Pedido::with(['status'])->
                                    where('status_id',2)->
                                    orwhere('status_id',3)->
                                    orwhere('status_id',4)->
                                    orwhere('status_id',5)->
                                    orderBy('status_id')->
                                    orderBy('dataEntrega')->paginate(25);
                    return view('listarVendas',['pedidos'=>$pedidos,'sucessoPagamento'=>'Pagamento finalizado com sucesso!']);
                    
                }
                // Se o valor pago for igual ao valor restante do pagamento
                elseif($request['valorPago'] == $request['valorRestantePagamento']){
                    // dd($request->all(),$pedido,$pagamento);                
                    $status = Status::where('status','PAGO TOTALMENTE')->first();
                    $pedido->status_id = $status->id;
                    $pedido->save();
                    // $itensPedido->save();
                    $pagamento->save();

                    // Retorna para tela de listagem de pedidos com msg de sucesso
                    $pedidos = Pedido::with(['status'])->
                                    where('status_id',2)->
                                    orwhere('status_id',3)->
                                    orwhere('status_id',4)->
                                    orwhere('status_id',5)->
                                    orderBy('status_id')->
                                    orderBy('dataEntrega')->paginate(25);
                    return view('listarVendas',['pedidos'=>$pedidos,'sucessoPagamento'=>'Pagamento finalizado com sucesso!']);
                }

                else{ //senão, retorna para listagem de vendas com um alerta de erro
                    $pedidos = Pedido::with(['status'])->
                                    where('status_id',2)->
                                    orwhere('status_id',3)->
                                    orwhere('status_id',4)->
                                    orwhere('status_id',5)->
                                    orderBy('status_id')->
                                    orderBy('dataEntrega')->paginate(25);
                return view('listarVendas',['pedidos'=>$pedidos,'erroPagamento'=>'Não é possível salvar o valor pago maior que o valor total do pagamento!']);
                }
                
            }
            // Caso Contrário, retorna para listargem das vendas
            else{
                $pedidos = Pedido::with(['status'])->
                                    where('status_id',2)->
                                    orwhere('status_id',3)->
                                    orwhere('status_id',4)->
                                    orwhere('status_id',5)->
                                    orderBy('status_id')->
                                    orderBy('dataEntrega')->paginate(25);
                return view('listarVendas',['pedidos'=>$pedidos,'erroPagamento'=>'Não foi possível registrar o pagamento desse pedido.']);
            }
        }
        // Caso o pedido não for encontrado
        else{
            $pedidos = Pedido::with(['status'])->
                                where('status_id',2)->
                                orwhere('status_id',3)->
                                orwhere('status_id',4)->
                                orwhere('status_id',5)->
                                orderBy('status_id')->
                                orderBy('dataEntrega')->paginate(25);
            return view('listarVendas',[
                                        'pedidos'=>$pedidos,
                                        'erroPagamento'=>'Não foi possível encontrar o pagamento'
                                        ]);
        }
        
        
        
          
        
    }

    // Filtra Pedido
    public function filtrarVenda(Request $request, Pedido $pedido){
        // dd($request->all());
        $filtro = $request->all();
        // dd($filtro);
        
        $pedidos = $pedido->filtro($filtro,25);

        return view('listarVendas',['pedidos'=>$pedidos,'filtro'=>$filtro,'achou'=> true]);
        // dd($pedidos);

    }

}
