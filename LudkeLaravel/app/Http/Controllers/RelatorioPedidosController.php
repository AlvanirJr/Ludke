<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\ItensPedido;
use App\Pedido;

class RelatorioPedidosController extends Controller
{
    //

    public function RelatorioPedidos($id){
        $view = 'relatorioPedido';
        $pedido = Pedido::find($id);
        $itens = ItensPedido::where('pedido_id', '=', $pedido->id)->get();
        
         
        

        $date = date('d/m/Y');
		$view = \View::make($view, compact('itens', 'date'))->render();
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view)->setPaper('a4', 'landscape');

		$filename = 'relatorioPedido'.$date;

		return $pdf->stream($filename.'.pdf');
    }
}
