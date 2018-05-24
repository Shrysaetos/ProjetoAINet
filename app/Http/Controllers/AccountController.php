<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;

use Illuminate\Http\Request;
use App\User;
use App\Account;
use App\AccountType;

class AccountController extends Controller
{


    public function index(User $user)
    {
        $this->authorize('list', $user);

        $accounts = Account::withTrashed()->where('owner_id', $user->id)->get();
        return view('accounts.list_all', compact('accounts', 'user'));
    }

    public function listOpenAccounts(User $user)
    {
        $this->authorize('list', $user);

        $accounts = Account::where('owner_id', $user->id)->get();
        return view('accounts.list_opened', compact('accounts', 'user'));
    }


    public static function listClosedAccounts (User $user){
    	

        $accounts = Account::onlyTrashed()->where('owner_id', $user->id)->get();
        return view('accounts.list_closed', compact('accounts', 'user'));
    }

    public function closeAccount (Account $account){
    	$account->delete();
    }

    public function reOpenAccount (Account $account){
    	$account->restore();
    }


    public function create(User $user)
    {
        $this->authorize('create', $user);

        $account_types = AccountType::all();
        $account = new Account;
        return view('accounts.add', compact('account', 'account_types', 'user'));
    } 


    public function store(StoreAccountRequest $request, User $user)
    {
        $this->authorize('create', $user);

        $data = $request->validated();

        Account::create($data);

        return redirect()
            ->route('account.accountsOpened')
            ->with('success', 'Account added successfully');
    }


    public function edit(Account $account)
    {
        $this->authorize('edit', $account);
        $account_types = AccountType::all();

        return view('accounts.edit', compact('account', 'account_types'));
    }


    public function update(UpdateUserRequest $request, Account $account)
    {
        $this->authorize('edit', $account);

        $data = $request->validated();

        $account->fill($data);
        $account->save();

        return redirect()
            ->route('account.accountsOpened')
            ->with('success', 'Account saved successfully');
    }


    public function delete(Account $account)
    {
        $this->authorize('delete', Account::class);

        $account->delete();

        return redirect()
            ->route('account.accountsOpened')
            ->with('success', 'Account deleted successfully');
    }



   

}
