<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Account;
use App\Movement;

class WelcomeController extends Controller
{

	public function home()
	{

		$users = User::all();
		$accounts = Account::all();
		$movements = Movement::all();

		return view('welcome', compact('users', 'accounts', 'movements'));

	}
}