<?php

namespace App\Policies;

use App\User;
use App\Account;
use App\Movement;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovementPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    



    public function edit(User $user, Movement $movement)
    {

    	$account = Account::where('id', $movement->account_id)->firstOrFail();

        if ($user->isAccountOwner($account)){
            return true;
        } 

        return false;
    }

    public function delete(User $user, Movement $movement)
    {

    	$account = Account::where('id', $movement->account_id)->firstOrFail();

        if ($user->isAccountOwner($account) && !$account->trashed()){
            return true;
        }

        return false;
    }


    public function uploadDocument (User $user, Movement $movement){
        $account = Account::where('id', $movement->account_id)->firstOrFail();

        if ($user->isAccountOwner($account)){
            return true;
        } 

        return false;
    }


}
