<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Dompdf\Dompdf;
use App\ItensPedido;
use App\Pedido;
use App\Cliente;
use App\User;
use App\Funcionario;
use App\Cargo;

class RelatorioVendasController extends Controller
{
    public function RelatorioGeral(Request $request){
        // Set variável filtro
        $filtro = $request->all();
        
        // filtra as vendas
        $vendas = self::filtrarVenda($filtro);
        
        $view = 'relatorioGeralVenda';
        // $vendas = Pedido::all();
        $total = 0;
        foreach ($vendas as $venda){
            $total += $venda->valorTotal;
        }
        $count = count($vendas);

        //dd($total);


        $date = date('d/m/Y');
        $view = \View::make($view, compact('vendas', 'total','count','date'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a4', 'landscape');

        $filename = 'relatorioGeralVendas'.$date;


        return $pdf->stream($filename.'.pdf');
    }


    // Filtra Vendas
    public function filtrarVenda($filtro){
        
        $vendas = [];
        if(isset($filtro['filtroRelatorioVendasStatus_id'])){
            $vendas = Pedido::where('status_id',intval($filtro['filtroRelatorioVendasStatus_id']))->where('tipo','v')->orWhere('tipo','mv')
                ->orderBy('status_id')->orderBy('dataEntrega')->get();
            return $vendas;
        }
        else if(isset($filtro['filtroRelatorioVendasNomeCliente'])){
            $user = User::where('name','LIKE','%'.strtoupper($filtro['filtroRelatorioVendasNomeCliente']).'%')->first();
            if(isset($user)){
                $cliente = Cliente::where('user_id',$user->id)->first();
                $vendas = Pedido::where('cliente_id',$cliente->id)->where('tipo','v')->orWhere('tipo','mv')
                    ->orderBy('status_id')->orderBy('dataEntrega')->get();
                    return $vendas;
            }else{
                return view('listarPedido',['vendas'=>[],'filtro'=>$filtro,'achou'=> true,'tipoFiltro'=>"Nome do Cliente"]);
            }
        }
        else if(isset($filtro['filtroRelatorioVendasNomeReduzido'])){

            $cliente = Cliente::where('nomeReduzido','LIKE','%'.strtoupper($filtro['filtroRelatorioVendasNomeReduzido']).'%')->first();
            if(isset($cliente)){
                $vendas = Pedido::where('cliente_id',$cliente->id)->where('tipo','v')->orWhere('tipo','mv')
                    ->orderBy('status_id')->orderBy('dataEntrega')->get();
                return $vendas;
            }
            else{
                return $vendas;
            }
        }
        else if(isset($filtro['filtroRelatorioVendasDataEntregaInicial']) && !isset($filtro['filtroRelatorioVendasDataEntregaFinal'])){
            $vendas = Pedido::whereDate('dataEntrega','>=',$filtro['filtroRelatorioVendasDataEntregaInicial'])->where('tipo','v')->orWhere('tipo','mv')
                ->orderBy('status_id')->orderBy('dataEntrega')->get();
                return $vendas;
        }
        else if(!isset($filtro['filtroRelatorioVendasDataEntregaInicial']) && isset($filtro['filtroRelatorioVendasDataEntregaFinal'])){
            $vendas = Pedido::whereDate('dataEntrega','<=',$filtro['filtroRelatorioVendasDataEntregaFinal'])->where('tipo','v')->orWhere('tipo','mv')
                ->orderBy('status_id')->orderBy('dataEntrega')->get();
                return $vendas;
        }
        else if(isset($filtro['filtroRelatorioVendasDataEntregaInicial']) && isset($filtro['filtroRelatorioVendasDataEntregaFinal'])){
            $vendas = Pedido::whereDate('dataEntrega','>=',$filtro['filtroRelatorioVendasDataEntregaInicial'])
                ->whereDate('dataEntrega','<=',$filtro['filtroRelatorioVendasDataEntregaFinal'])->where('tipo','v')->orWhere('tipo','mv')
                ->orderBy('status_id')->orderBy('dataEntrega')->get();
                return $vendas;
        }
        else if(isset($filtro['filtroRelatorioVendasEntregador'])){
            $vendas = Pedido::where('entregador_id',$filtro['filtroRelatorioVendasEntregador'])->where('tipo','v')->orWhere('tipo','mv')->get();
                return $vendas;
        }
        else{
            $vendas = Pedido::where('tipo','v')->orWhere('tipo','mv')->get();
            return $vendas;
        }

    }
}
