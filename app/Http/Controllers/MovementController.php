<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\UpdateMovementRequest;


use Illuminate\Http\Request;
use App\Account;
use App\Movement;
use App\MovementCategory;
use App\User;

class MovementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index (Account $account){

        

        $this->authorize('list', $account);

    	$movements = Movement::where('account_id', $account->id)->get();
        return view('movements.list', compact('account', 'movements'));
    }


    public function create(User $user)
    {
        $this->authorize('create', $user);

        $movement_categories = MovementCategory::all();
        $movement = new Movement;
        return view('movements.add', compact('movement', 'movement_categories', 'user'));
    } 


    public function store(StoreMovementRequest $request, User $user)
    {
        $this->authorize('create', $user);

        $data = $request->validated();

        $newMovement = Movement::create($data);
        
        Movement::recalculateMovementsDate($newMovement);
        

        return redirect()
            ->route('movement.index')
            ->with('success', 'Movement added successfully');
    }



    public function edit(Movement $movement)
    {
        $this->authorize('edit', $movement);
        $movement_categories = MovementCategory::all();

        Movement::recalculateMovementsDate($movement);

        return view('movements.edit', compact('movement', 'movement_categories'));
    }


    public function update(UpdateMovementRequest $request, Movement $movement)
    {
        $this->authorize('edit', $movement);

        $data = $request->validated();

        $movement->fill($data);
        $movement->save();

        return redirect()
            ->route('movement.index')
            ->with('success', 'Movement saved successfully');
    }


    public function delete(Movement $movement)
    {
        $this->authorize('delete', Movement::class);

        $movement->delete();

        return redirect()
            ->route('movement.index')
            ->with('success', 'Movement deleted successfully');
    }


}
