<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\ItensPedido;
use App\Pedido;
use App\Cliente;

class RelatorioPedidosController extends Controller
{
    //

    public function RelatorioPedidos($id){
        $view = 'relatorioPedido';
        $pedido = Pedido::find($id);
        $itens = ItensPedido::where('pedido_id', '=', $pedido->id)->get();
        $clientes = Cliente::where('id', '=', $pedido->cliente_id)->get();
        //dd($clientes);
        $soma = 0;
        foreach ($itens as $iten){
            $soma += $iten->valorReal;
        }

        #####Soma



        $date = date('d/m/Y');
		$view = \View::make($view, compact('itens', 'clientes','soma',  'date'))->render();
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view)->setPaper('a6', 'landscape');

		$filename = 'relatorioPedido'.$date;


		return $pdf->stream($filename.'.pdf');
    }



    public function RelatorioGeral(){
        $view = 'relatorioGeralPedido';
        $pedidos = Pedido::all();


        $date = date('d/m/Y');
        $view = \View::make($view, compact('pedidos', 'date'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a4', 'landscape');

        $filename = 'relatorioGeralPedido'.$date;


        return $pdf->stream($filename.'.pdf');
    }
}
