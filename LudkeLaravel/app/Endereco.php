<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //
    protected $fillable = ['rua','numero','bairro','cidade','uf','cep'];

    public function users(){
        return $this->belongsTo('App\User');
    }
}
