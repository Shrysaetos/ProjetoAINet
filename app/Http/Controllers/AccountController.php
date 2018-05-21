<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Account;

class AccountController extends Controller
{
<<<<<<< HEAD

    public function index(User $user)
    {
        $this->authorize('list', $user);

        $accounts = Account::where('owner_id', $user->id);
        return view('account.userAccounts', compact('accounts'));
    }

    public static function listClosedAccounts (User $user){
    	$this->authorize('listClosed', $user);

        $accounts = Account::onlyTrashed()->('owner_id', $user->id);
        return view('account.accountsClosed', compact('accounts'));
    }

    public function closeAccount (Account $account){
    	//FALTA CODIGO
    }

    public function reOpenAccount (Account $account){
    	$account->restore();
    }


    /**public function create(User $user)
    {
        $this->authorize('create', $user);

        $account = new Account;
        return view('users.add', compact('account'));
    } */



=======
    public function index()
    {
        $accounts = Account::all();
        return view('accounts.index', compact('accounts'));
    }
>>>>>>> 7423ee4406a3d8929e14e5a262ea977b048248bd
}
