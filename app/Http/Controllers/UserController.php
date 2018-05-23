<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('list', User::class);

        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $user = new User;
        return view('users.add', compact('user'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User added successfully');
    }

    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('edit', $user);

        $data = $request->validated();

        $user->fill($data);
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User saved successfully');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function profile(){
        return view('profile', array('user' => Auth::user()));
    }

    public function update_photo(Request $request) {

        if($request->hasFile('profile_photo')){
            $profile_photo = $request->file('profile_photo');
            $filename = time() . '.' . $profile_photo->getClientOriginalExtension();
            Image::make($profile_photo)->resize(300, 300)->save(public_path('/uploads/profile-photos/' . $filename));

            $user = Auth::user();
            $user->profile_photo = $filename;
            $user->save();
        }

        return view('profile', array('user' => Auth::user()));
    }

    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }

    public function changePassword(Request $request){
 
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
 
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:3|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
 
    return redirect()->back()->with("success","Password changed successfully !");
    }

    public function showChangeEmailForm(){
        return view('auth.changeemail');
    }

    public function changeEmail(Request $request){
 
        if(strcmp(Auth::user()->email, $request->get('email')) == 0){
            //Current email and new email are same
            return redirect()->back()->with("error","New Email cannot be same as your current email. Please choose a different email.");
        }

        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
        ]);
 
        //Change Email
        $user = Auth::user();
        $user->email = $request->get('email');
        $user->save();
 
    return redirect()->back()->with("success","Email changed successfully !");
    }

    public function showChangeNameForm(){
        return view('auth.changename');
    }

    public function changeName(Request $request){
 
        if(strcmp(Auth::user()->name, $request->get('name')) == 0){
            //Current name and new name are same
            return redirect()->back()->with("error","New Name cannot be same as your current name. Please choose a different name.");
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
 
        //Change Name
        $user = Auth::user();
        $user->name = $request->get('name');
        $user->save();
 
    return redirect()->back()->with("success","Name changed successfully !");
    }

    public function showChangePhoneForm(){
        return view('auth.changephone');
    }

    public function changePhone(Request $request){
 
        if(strcmp(Auth::user()->phone, $request->get('phone')) == 0){
            //Current phone and new phone are same
            return redirect()->back()->with("error","New Phone cannot be same as your current phone. Please choose a different phone.");
        }

        $validatedData = $request->validate([
            'phone' => 'required|min:9|max:9',
        ]);
 
        //Change Email
        $user = Auth::user();
        $user->phone = $request->get('phone');
        $user->save();
 
    return redirect()->back()->with("success","Phone changed successfully !");
    }

    public function showAssociates(){
        return view('');
    }
}

