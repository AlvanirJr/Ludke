<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    //
    protected $fillable = ['formaPagamento','desconto','dataEntrega','valorTotal'];

    function funcionario(){
        return $this->belongsTo('App\Funcionario');
    }
    function cliente(){
        return $this->belongsTo('App\Cliente');
    }

    function itensPedidos(){
        return $this->hasMany('App\ItensPedido','pedido_id');
    }
}
