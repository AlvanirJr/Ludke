<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    //

    public function cargo(){
        return $this->hasOne('App\Cargo','cargo_id');
    }
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
