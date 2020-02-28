<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   Produto extends Model
{
    //
    protected $fillable = ['nome', 'validade', 'preco', 'descricao'];

    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }

    public function fotosProduto(){
        return $this->hasMany('App\FotosProduto');
    }

    function itensPedidos(){
        return $this->hasMany('App\ItensPedido','produto_id');
    }
}
