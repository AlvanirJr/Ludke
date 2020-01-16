<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosProduto extends Model
{
    //
    public function produto(){
        return $this->belongsTo('App\Produtos','produto_id');
    }
}
