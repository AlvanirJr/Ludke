<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    //
    protected $fillable = ['nome', 'validade', 'quantidade', 'preco', 'descricao'];

    public function categorias(){
        return $this->belongsTo('App\Categoria', 'categoria_id');
    }
}
