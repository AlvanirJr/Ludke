<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    //
    protected $fillable = ['numero'];

    public function user(){
        return $this->belongsTo('App\User','user_id');  
    }
}
