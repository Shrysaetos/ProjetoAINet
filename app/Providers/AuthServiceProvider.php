<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
use App\Policies\AccountPolicy;
use App\Account;
use App\Policies\MovementPolicy;
use App\Movement;
use App\Document;
use App\Policies\DocumentPolicy;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */





    protected $policies = [
        User::class => UserPolicy::class,
        Account::class => AccountPolicy::class,
        Movement::class => MovementPolicy::class,  
        Document::class => DocumentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
