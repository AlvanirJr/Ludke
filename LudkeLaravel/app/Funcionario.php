<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    //

    public function cargo(){
        return $this->belongsTo('App\Funcionario');
    }
    public function user(){
        return $this->belongsTo('App\Funcionario');
    }
}
