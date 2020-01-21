<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    //
    protected $fillable = ['nome'];

    public function funcionario(){
        return $this->hasOne('App\Cargo','cargo_id');
    }
}
