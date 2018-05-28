<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function list(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function edit(User $user, User $model)
    {
        return $user->isPublisher() ||
        ($user->isClient() && $user->id == $model->id);
    }

    public function delete(User $user)
    {
        return false;
    }


    public function createAccount (User $user, User $requester){

        return $user->id == $requester->id;


    }

}
