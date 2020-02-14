<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    //
    protected $fillable = ['numero'];

    public function user(){
        return $this->hasOne('App\User','telefone_id');  
    }
}
