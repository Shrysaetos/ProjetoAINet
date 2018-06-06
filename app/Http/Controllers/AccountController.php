<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;

use Illuminate\Http\Request;
use App\User;
use App\Account;
use App\AccountType;
use App\Movement;

class AccountController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(User $user)
    {
        $this->authorize('listAccounts', $user);

        $accounts = Account::withTrashed()->where('owner_id', $user->id)->get();
        return view('accounts.list_all', compact('accounts', 'user'));
    }

    public function listOpenAccounts(User $user)
    {
        $this->authorize('listAccounts', $user);

        $accounts = Account::where('owner_id', $user->id)->get();

        return view('accounts.list_opened', compact('accounts', 'user'));
    }


    public function listClosedAccounts (User $user){

        $this->authorize('listAccounts', $user);

        $accounts = Account::onlyTrashed()->where('owner_id', $user->id)->get();
        return view('accounts.list_closed', compact('accounts', 'user'));
    }

    public function closeAccount (Account $account){
    	$account->delete();

        return redirect()
            ->route('account.accountsOpened', $account->owner_id)
            ->with('success', 'Account closed successfully');
    }

    public function reOpenAccount ($accountId){
        $account = Account::withTrashed()->where('id', $accountId)->firstOrFail()->restore();      

         return redirect()
            ->route('account.accountsOpened', $account->owner_id)
            ->with('success', 'Account reopened successfully');
    }


    public function create()
    {
        $account_types = AccountType::all();
        $account = new Account;
        return view('accounts.add', compact('account', 'account_types', 'user'));
    } 


    public function store(StoreAccountRequest $request)
    {
        

        $data = $request->validated();
        $data['owner_id'] = $request->user()->id;
        $data['current_balance'] = $data['start_balance'];

        if (!isset($data['start_balance'])){
            $data['start_balance'] = 0;
        }
        

        Account::create($data);

        return redirect()
            ->route('account.accountsOpened', $request->user()->id)
            ->with('success', 'Account added successfully');
    }


    public function edit(Account $account)
    {
        $this->authorize('edit', $account);
        $account_types = AccountType::all();

        return view('accounts.edit', compact('account', 'account_types'));
    }


    public function update(UpdateAccountRequest $request, Account $account)
    {
        $this->authorize('edit', $account);

        $data = $request->validated();


        

        if (isset($data['start_balance'])) {
            if (is_null($account->last_movement_date)){
                $account->current_balance = $data['start_balance'];
            } else if ($data['start_balance'] != $account->start_balance){
                Movement::recalculateMovementsBalance($account, $data['start_balance']);
            }
        }

        $account->fill($data);
        $account->save();

        return redirect()
            ->route('account.accountsOpened', $request->user()->id)
            ->with('success', 'Account saved successfully');
    }


    public function delete($accountId)
    {

        $account = Account::withTrashed()->where('id', $accountId)->firstOrFail();
        $this->authorize('deleteAccount', $account);

        $account->forceDelete();

        return redirect()
            ->route('account.accountsOpened', $account->owner_id)
            ->with('success', 'Account deleted successfully');
    }



   

}
