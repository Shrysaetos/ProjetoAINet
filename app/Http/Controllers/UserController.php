<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Image;

use Khill\Lavacharts\Lavacharts;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('list', User::class);

        $name = $request->input('name');
        if($name!= ""){
            $users = User::where('name', 'LIKE', '%' . $name . '%')
                ->get();
        } else {
            $users = User::all();
        }

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

        return view('users.edit_user', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            $profile_photo = $request->file('profile_photo');
            $filename = time() . '.' . $profile_photo->getClientOriginalExtension();
            Image::make($profile_photo)->save(public_path('uploads/profiles/' . $filename));

            $user->profile_photo = $filename;
        } else {
            if (!($request->hasFile('profile_photo'))){
                $user->profile_photo = $user->profile_photo;
            }
        }

        if((empty($request->input('email'))) && (empty($request->input('name'))) && (empty($request->input('phone'))) && (empty($request->input('profile_photo')))){
            return redirect()->back()->with("error","At least one of the fields must be filed.");
        }

        if($request->get('phone')!= 0) {
            if(strcmp(Auth::user()->email, $request->get('email')) == 0){
                //Current email and new email are same
                return redirect()->back()->with("error","New Email cannot be same as your current email. Please choose a different email.");
            }
        }

        if($request->get('name')!= 0) {
            if(strcmp(Auth::user()->name, $request->get('name')) == 0){
                //Current name and new name are same
                return redirect()->back()->with("error","New Name cannot be same as your current name. Please choose a different name.");
            }
        }

        if($request->get('phone')!= 0) {
            if(strcmp(Auth::user()->phone, $request->get('phone')) == 0){
                //Current phone and new phone are same
                return redirect()->back()->with("error","New Phone cannot be same as your current phone. Please choose a different phone.");
            }
        } else {
            $user->phone = $request->get('phone');
        }
        $user->save();
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function profile(){
        return view('profile', array('user' => Auth::user()));
    }

    public function showListForAdmins(Request $request){

        $this->authorize('list', User::class);
        if(Auth::user()->admin == 0){
            abort(403, 'Unauthorized action');
        }
        $name = $request->query('name');
        $admin = $request->query('admin');
        $blocked = $request->query('blocked');
        if($name != "" || $admin != "" || $blocked!= ""){
            if ($admin == "admin"){
                $admin = 1;
            } elseif ($admin == "normal") {
                $admin = 0;
            }
            if ($blocked == "blocked"){
                $blocked = 1;
            } elseif ($blocked == "unblocked") {
                $blocked = 0;
            }
            $users = User::where('name', 'LIKE', '%' . $name . '%')
                ->where('admin', 'LIKE', $admin)
                ->where('blocked', 'LIKE', $blocked)
                ->get();
        } else {
            $users = User::all();
        }

        return view('admin.index', compact('users'));
    }

    public static function isAssociate(User $user){
        $me = Auth::user();
        $his_id = $user->id;
        $my_id = $me->id;
        $associate_members = DB::table('associate_members')->get();
        foreach($associate_members as $associate_member){
            if ($associate_member->main_user_id == $my_id && $associate_member->associated_user_id == $his_id){
                return true;
            }
        }
        return false;
    }    

    public function showAssociates(){
        $users = User::all();
        foreach ($users as $user) {
            if (self::isAssociate($user)){
                $my_associates = $user;
            }
        }
        return view('associates.index', compact('my_associates'));
    }


    public static function amAssociate(User $user){
        $me = Auth::user();
        $his_id = $user->id;
        $my_id = $me->id;
        $associate_members = DB::table('associate_members')->get();
        foreach($associate_members as $associate_member){
            if ($associate_member->main_user_id == $his_id && $associate_member->associated_user_id == $my_id){
                return true;
            }
        }
        return false;
    }

    public function showAssociatesOf(){
        $users = User::all();
        foreach ($users as $user) {
            if (UserController::amAssociate($user)){
                return view('associates.index_associate_of', compact('$user'));
            }
        }
        return view('associates.index_associate_of', compact('my_associates'));
    }

    public function addMemberToMyGroup(User $user){
        $my_id = Auth::user()->id;
        $his_id = $user->id;
        $data = array('main_user_id' => $my_id, 'associated_user_id' => $his_id);
        DB::table('associate_members')::create($data);
    }

    public function deleteMemberFromMyGroup(){

    }
    
    public static function searchNormal(Request $request)
    {
        $name = $request->input('name');
        $users = User::where('name', 'LIKE', '%' . $name . '%')
            ->get();

    return view('users.index', compact('users'));
    }


    public function blockUser(User $user){

        if(Auth::user()->id == $user->id){
            abort(403, 'Unauthorized action');
        } else if (Auth::user()->admin != 1){
            abort(403, 'Unauthorized action');
        } else {
            $user->blocked = 1;
            $user->save();
        }
        return redirect()->back();
    }

    public function unblockUser(User $user){
        if(Auth::user()->id == $user->id){
            abort(403, 'Unauthorized action');
        } else if (Auth::user()->admin != 1){
            abort(403, 'Unauthorized action');
        } else {
            $user->blocked = 0;
            $user->save();
        }
        return redirect()->back();
    }

    public function promoteUser(User $user){
        if(Auth::user()->id == $user->id){
            abort(403, 'Unauthorized action');
        } else if (Auth::user()->admin != 1){
            abort(403, 'Unauthorized action');
        } else {
            $user->admin = 1;
            $user->save();
        }
        return redirect()->back();
    }

    public function demoteUser(User $user){
        if(Auth::user()->id == $user->id){
            abort(403, 'Unauthorized action');
        } else if (Auth::user()->admin != 1){
            abort(403, 'Unauthorized action');
        } else {
            $user->admin = 0;
            $user->save();
        }
        return redirect()->back();    
    }
}

