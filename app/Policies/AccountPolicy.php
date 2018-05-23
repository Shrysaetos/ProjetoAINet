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
    public function __construct()
    {
    
    }


    public function list(User $user)
    {
        $userAssociateMembers = AssociateMember::where('main_user_id', $user->id)
        if ()
        return true;
    }

}
