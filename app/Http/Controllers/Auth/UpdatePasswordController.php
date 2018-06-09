<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {

        $this->middleware('auth');

    }
    /**
     * Show the form to change the user password.
     */
    public function index(){
        return view('auth.changepassword');
    }

    /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(UpdateUserRequest $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|string|min:3|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = Auth::user();
        $hashedPassword = $user->password;

        if (Hash::check($request->old_password, $hashedPassword) && Hash::check($request->password, $request->password_confirmation)) {
            //Change the password
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            $request->session()->flash('success', 'Your password has been changed.');

            return back();
        }
        $request->session()->flash('failure', 'Your password has not been changed.');

        return back();


    }
}
