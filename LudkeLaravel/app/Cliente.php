<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $fillable = ['nomeReduzido',
                        'nomeResponsavel',
                        'cpfCnpj',
                        'tipo',
                        'inscricaoEstadual'];
}
