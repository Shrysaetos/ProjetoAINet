<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function index (Account $account){
    	$movements = Movement::where('account_id', $account->id)->get();
        return view('accounts.list_all', compact('accounts'));
    }
}
