<?php

namespace App\Policies;

use App\User;
use App\Account;
use App\Movement;
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



    public function edit(User $user, Account $account)
    {

        if ($user->isAccountOwner($account)){
            return true;
        } 

        return false;
    }


    public function list(User $user, Account $account)
    {

        if ($user->isAccountOwner($account) && !$account->trashed()){
            return true;
        }  

        return false;


    }


    public function createMovement(User $user, Account $account)
    {
        if ($user->isAccountOwner($account) && !$account->trashed()){
            return true;
        } 

        return false;
    }



    public function delete(User $user, Account $account)
    {

        if (is_null($account->last_movement_date) || $account->trashed()){
            if ($user->isAccountOwner($account)){
                return true;
            }

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

        if ($user->isAccountOwner($account)){
            return true;
        }

        return false;
    }


}
