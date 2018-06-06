<?php

namespace App\Policies;

use App\User;
use App\Account;
use App\AssociateMember;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */


    public function delete(User $user, Account $account)
    {


        if (is_null($account->last_movement_date) || $account->trashed() && $user->isAccountOwner($account)){
            return true;
        }

        return false;
    }


    public function edit(User $user, Account $account)
    {

        if ($user->isAccountOwner($account)){
            return true;
        } 

        return false;
    }




    public function close(User $user, Account $account){
        if ($user->isAccountOwner($account)){
            return true;
        } 
        return false;

    }

    public function reopen (User $user, Account $account){

        if ($user->isAccountOwner($account) || $user->isAdmin() == 1){
            return true;
        }

        return false;
    }


}
