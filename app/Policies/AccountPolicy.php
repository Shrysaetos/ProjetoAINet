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


    public function list(User $user, Account $account)
    {
        $userAssociateMembers = AssociateMember::where('main_user_id', $user->id);

        if ($user->isAccountOwner($account)){
            return true;
        } else {

            foreach ($userAssociateMembers as $associate) {
                if ($user->id == $associate->id){
                    return true;
                 }
            }

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

    public function delete(User $user, Account $account)
    {
        if (is_null($account->last_movement_date) || $account->trashed() && $user->isAccountOwner()){
            return true;
        }
        return false;
    }


    public function close(User $user, Account $account){
        if ($user->isAccountOwner($account)){
            return true;
        } 

    }


}
