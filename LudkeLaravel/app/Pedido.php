<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    //
    protected $fillable = ['formaPagamento','desconto','dataEntrega','valorTotal'];

    function funcionario(){
        return $this->belongsTo('App\Funcionario');
    }
    function cliente(){
        return $this->belongsTo('App\Cliente');
    }

    function itensPedidos(){
        return $this->hasMany('App\ItensPedido','pedido_id');
    }


    public function filtro($filtro){

        try {
            //code...
            return $this->where(function($query) use ($filtro){
                if(isset($filtro['status'])){
                    $query->where('status',$filtro['status']);
                }
                if(isset($filtro['dataEntrega'])){
                    $query->where('dataEntrega',$filtro['dataEntrega']);
                }
                if(isset($filtro['cliente'])){
                    $user = User::where('name','LIKE','%'.strtoupper($filtro['cliente']).'%')->first();
                    $cliente = Cliente::where('user_id',$user->id)->first();
                    $query->where('cliente_id',$cliente->id);
                }
            })->paginate(1);
        } catch (\Throwable $th) {
            return [];
        }           

    }
}
