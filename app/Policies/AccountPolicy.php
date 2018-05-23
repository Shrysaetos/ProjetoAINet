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


    public function list(Account $account)
    {
        $userAssociateMembers = AssociateMember::where('main_user_id', $user->id);

        if (Auth::user()->isAccountOwner($account)){
            return true;
        } else {

            foreach ($userAssociateMembers as $associate) {
                if (Auth::user()->id == $associate->id){
                    return true;
                 }
            }

        }

        
        return true;
    }

    public function create(Account $account)
    {
        if (Auth::user()->isAccountOwner($account)){
            return true;
        }

        return false;
    }


    public function edit(Account $account, Account $model)
    {

        if (Auth::user()->isAccountOwner()){
            return true;
        } 

        return false;
    }

    public function delete(Account $account)
    {
        if (is_null($account->last_movement_date) || $account->trashed() && Auth::user()->isAccountOwner()){
            return true;
        }
        return false;
    }

}
