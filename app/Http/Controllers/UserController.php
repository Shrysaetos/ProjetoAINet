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
        $count = DB::table('users')->count();
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
}

