<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;

use Illuminate\Http\Request;
use App\User;
use App\Account;

class AccountController extends Controller
{


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
        return view('account.create', compact('account'));
    } */


    public function store(StoreAccountRequest $request, User $user)
    {
        $this->authorize('create', $user);

        $data = $request->validated();

        Account::create($data);

        return redirect()
            ->route('account.accountsOpened')
            ->with('success', 'User added successfully');
    }


    /**public function edit(Account $account)
    {
        $this->authorize('edit', $account);

        return view('account.edit', compact('account'));
    }*/


    public function update(UpdateUserRequest $request, Account $account)
    {
        $this->authorize('edit', $account);

        $data = $request->validated();

        $account->fill($data);
        $account->save();

        return redirect()
            ->route('account.accountsOpened')
            ->with('success', 'User saved successfully');
    }


    public function delete(Account $account)
    {
        $this->authorize('delete', Account::class);

        $account->delete();

        return redirect()
            ->route('account.accountsOpened')
            ->with('success', 'User deleted successfully');
    }



   

}
