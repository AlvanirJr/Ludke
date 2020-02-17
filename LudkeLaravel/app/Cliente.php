<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $fillable = ['nomeReduzido',
                        'nomeResponsavel',
                        'cpfCnpj',
                        'tipo',
                        'inscricaoEstadual'];


    function user(){
        return $this->belongsTo('App\User');
    }
    function pedidos(){
        return $this->hasMany('App\Pedido','cliente_id');
    }
}
