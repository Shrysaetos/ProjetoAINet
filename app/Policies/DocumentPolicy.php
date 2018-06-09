<?php

namespace App\Policies;

use App\User;
use App\Document;
use App\Movement;
use App\Account;
use App\AssociateMember;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    
    public function delete(User $user, Document $document)
    {
        $movement = $document->getMovement();


        $account = Account::where('id', $movement->account_id)->firstOrFail();  

        if ($user->isAccountOwner($account)){
            return true;
        }

            return false;
    }

    public function download (User $user, Document $document){

        $movement = $document->getMovement();

        $account = Account::where('id', $movement->account_id)->firstOrFail();

        if ($user->isAccountOwner($account)){
            return true;
        } else {

            $userAssociateMembers = AssociateMember::where('main_user_id', $user->id);
            foreach ($userAssociateMembers as $associate) {
                if ($user->id == $associate->id){
                    return true;
                 }
            }
        }

        return false;
        
    }
}
