<?php

namespace App\Policies;

use App\User;
use App\Account;
use App\AssociateMember;
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
    

    public function create(User $user, Account $account)
    {
        if ($user->isAccountOwner($account)){
            return true;
        } 

        return false;
    }


    public function list(User $user, Account $account)
    {

        if ($user->isAccountOwner($account)){
            return true;
        }  


    }



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

        if ($user->isAccountOwner($account)){
            return true;
        }

        return false;
    }


}
