<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use App\Account;
use App\Movement;
use App\MovementCategory;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('list', User::class);

        $users = User::all();
        if(Auth::user()->admin == 0){
            return view('users.index', compact('users'));
        } else {
            return view('admin.index', compact('users'));
        }
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

    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->hasFile('profile_photo')) {
            $profile_photo = $request->file('profile_photo');
            $filename = time() . '.' . $profile_photo->getClientOriginalExtension();
            Image::make($profile_photo)->save(public_path('uploads/profiles/' . $filename));

            $user->profile_photo = $filename;
        }

        if(strcmp(Auth::user()->email, $request->get('email')) == 0){
            //Current email and new email are same
            return redirect()->back()->with("error","New Email cannot be same as your current email. Please choose a different email.");
        }
 
        if(strcmp(Auth::user()->name, $request->get('name')) == 0){
            //Current name and new name are same
            return redirect()->back()->with("error","New Name cannot be same as your current name. Please choose a different name.");
        }

        if(strcmp(Auth::user()->phone, $request->get('phone')) == 0){
            //Current phone and new phone are same
            return redirect()->back()->with("error","New Phone cannot be same as your current phone. Please choose a different phone.");
        }

        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|min:9|max:9',
            'photo' => 'nullable|mimes:jpg,png',
        ]);

        if(!($validatedData)){
            return redirect()->back()->with("error","Data not valid.");
        } else {
            $user->save();
        }
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function profile(){
        return view('profile', array('user' => Auth::user()));
    }


    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }

    public function changePassword(Request $request){
 
        if(empty($request->input('current-password')) || empty($request->input('new-password')) || empty($request->input('new-password-confirmation'))){
            return redirect()->back()->with("error","All of the fields must be filed.");
        }

        if (!(Hash::check($request->get('current-password'),  Auth::user()->password) && $request->get('new-password') == $request->get('new-password-confirmation'))) {
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
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
 
    return redirect()->back()->with("success","Password changed successfully!");
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


    public function amAssociate(User $user){
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
            if (self::amAssociate($user)){
                $my_associates = $user;
            }
        }
        return view('associates.index_associate_of', compact('my_associates'));
    }

    public function addMemberToMyGroup(){
        $user = Auth::user();
        DB::table('associate_members')::create();
    }

    public static function searchNormal(Request $request)
    {
        $name = $request->input('name');
        $users = User::where('name', 'LIKE', '%' . $name . '%')
            ->get();

    return view('users.index', compact('users'));
    }

    public static function searchAdmin(Request $request)
    {

        $builder = User::query();

        if($request->has('name')){
            $name = $request->input('name');
            $builder = User::where('name', 'LIKE', '%' . $name . '%')
                ->get();
        } elseif ($request->has('admin')) {
            $admin = $request->input('admin');
            $builder = User::where('admin', '=', $admin)
                ->get();
        } elseif ($request->has('blocked')) {
            $blocked = $request->input('blocked');
            $builder = User::where('blocked', '=', $blocked)
                ->get();
        }

        $users = $builder->orderBy('name')->paginate(5);

    return view('admin.index', compact('users'));
    }

    public function blockUser(User $user){

        if(Auth::user()->id != $user->id){
            if(Auth::user()->admin == 1){
                $user->blocked = 1;
                $user->save();
            }
        }
        return redirect()->back();
    }

    public function unblockUser(User $user){
        if(Auth::user()->id != $user->id){
            if(Auth::user()->admin == 1){
                $user->blocked = 0;
                $user->save();
            }
        }
        return redirect()->back();
    }

    public function promoteUser(User $user){
        if(Auth::user()->id != $user->id){
            if(Auth::user()->admin == 1){
                $user->admin = 1;
                $user->save();
            }
        }
        return back();       
    }

    public function demoteUser(User $user){
        if(Auth::user()->id != $user->id){
            if(Auth::user()->admin == 1){
                $user->admin = 0;
                $user->save();
            }
        }
        return back();     
    }



    public function generalStats(){

        $myGrandTotal = 0;
        $accounts = Account::all();
        $movements = Movement::all();
        $movement_categories = MovementCategory::all();

        $percentages = array();
        $myAccounts = array();
        $categoryTotal = array();
        $typeTotal = array();



        //calcular valor total
        foreach ($accounts as $account) {
            if ($account->owner_id == Auth::user()->id){
                $myGrandTotal = $myGrandTotal + $account->current_balance;
                array_push($myAccounts, $account);
            }
        }


        //calcular a percentagem que detem cada conta
        foreach ($accounts as $account) {
            if ($account->owner_id == Auth::user()->id){
                $percentages[$account->code] = ($account->current_balance * 100)/$myGrandTotal;
            }
        }


        foreach ($movements as $movement) {
            foreach ($myAccounts as $account) {
                if ($movement->account_id == $account->id){
                    $categoryTotal[$movement->movement_category_id]= $categoryTotal[$movement->movement_category_id] + $movement->value;
                }
            }


            foreach ($movement_categories as $category) {
                if (array_key_exists($category->id, $categoryTotal)){
                    $typeTotal[$category->type] = $typeTotal[$category->type] + $movement->value;
                }
            }

        }


        $lavaCategories = new Lavacharts();
        $lavaCategoryType = new Lavacharts();

        


        //return 


   }


}

