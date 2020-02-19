<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function view_admin(User $user)
    {
        //dd($user->tipo);
        if($user->tipo == 'admin'){
            return true;
        }
        else{
            return false;
        }

    }


    public function view_gerenteAdmin(User $user){
        //dd($user->tipo);
        if($user->tipo == 'gerenteAdmin'){
            return true;
        }
        else{
            return false;
        }
    }

    public function view_gerenteGeral(User $user){
        if($user->tipo == 'gerenteGeral'){
            return true;
        }
        else{
            return false;
        }
    }

    public function view_vendedor(User $user){

        if($user->tipo == 'vendedor'){
            return true;
        }
        else{
            return false;
        }
    }

    public function view_salsicheiro(User $user){
        if($user->tipo == 'salsicheiro'){
            return true;
        }
        else{
            return false;
        }
    }
}
