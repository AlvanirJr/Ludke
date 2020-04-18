<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{

    public $fillable = ['dataVencimento',
                        'dataPagamento',
                        'obs',
                        'descontoPagamento',
                        'valorTotalPagamento',
                        'valorPago',
                        'status'];

    public function funcionario(){
        return $this->belongsTo('App\Pedido');
    }
    public function pedido(){
        return $this->belongsTo('App\Funcionario');
    }
}
