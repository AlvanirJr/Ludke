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

    public function funcionario(){
        return $this->belongsTo('App\Funcionario');
    }
    function pedidos(){
        return $this->hasMany('App\Pedido','cliente_id');
    }
}
