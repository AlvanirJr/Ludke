<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   Produto extends Model
{
    //
    protected $fillable = ['nome', 'validade', 'preco', 'descricao'];

    public function categorias(){
        return $this->belongsTo('App\Categoria', 'categoria_id');
    }

    public static  $rules =[
        'nome' => 'required|',
        'validade' => 'required|',
        // 'quantidade' => 'required|min:1|',
        'preco' => 'required|',
        'descricao' => 'required',
    ];
}
