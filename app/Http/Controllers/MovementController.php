<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\UpdateMovementRequest;


use Illuminate\Http\Request;
use App\Account;
use App\Movement;
use App\MovementCategory;
use App\User;
use Carbon\Carbon;

class MovementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index ($accountId){

        $account = Account::withTrashed()->where('id', $accountId)->firstOrFail();

        $this->authorize('list', $account);

    	$movements = Movement::where('account_id', $accountId)->orderBy('date', 'desc')->get();
        return view('movements.list', compact('account', 'movements'));
    }


    public function create($accountId)
    {
        $account = Account::withTrashed()->where('id', $accountId)->firstOrFail();

        $this->authorize('createMovement', $account);

        $movement_categories = MovementCategory::all();
        $movement = new Movement;
        return view('movements.add', compact('movement', 'movement_categories', 'account'));
    } 


    public function store(StoreMovementRequest $request, Account $account)
    {


        $this->authorize('createMovement', $account);


        $data = $request->validated();
        $data['account_id'] = $account->id;
        $data['start_balance'] = $account->current_balance;

        $movementType = MovementCategory::where('id', $data['movement_category_id'])->firstOrFail();


        if ($movementType->type == 'expense'){
            $data['end_balance'] = $data['start_balance'] - $data['value'];

        }

        if ($movementType->type == 'revenue'){
            $data['end_balance'] = $data['start_balance'] + $data['value'];

        }  

        $data['type'] = $movementType->type;  
        $data['created_at'] = Carbon::now();

        $newMovement = Movement::create($data);

        Movement::recalculatMovimentAddedOrEdited($newMovement);

        if(isset($data['document_file'])){
            $extention = \File::extension($data['document_file']->getClientOriginalName());
            $file_name = $data['document_file']->getClientOriginalName();
            if($extention == "jpg"){
                $extention = "jpeg";
                $file_name = str_replace(".jpg", ".jpeg", $file_name);
            }

            $document = array(
                "created_at" => Carbon::now(),
                "description" => $data['document_description'],
                "original_name" => $file_name,
                "type" => $extention,
            );

            $newDocument = Document::create($document);

            $data['document_file']->storeAs("documents/{$account->id}", "{$new_mov->id}.{$extention}");

            $newMovement->document_id=$newDocument->id;
            $newMovement->save();

        }         
        
        
        


        

        return redirect()
            ->route('movement.index', $account)
            ->with('success', 'Movement added successfully');
    }



    public function edit(Movement $movement)
    {
        $this->authorize('edit', $movement);
        $movement_categories = MovementCategory::all();

        

        return view('movements.edit', compact('movement', 'movement_categories'));
    }


    public function update(UpdateMovementRequest $request, Movement $movement)
    {

        $account = Account::where('id', $movement->account_id)->firstOrFail();

        $this->authorize('edit', $movement);


        $data = $request->validated();


         if(isset($data['movement_category_id']) && $data['movement_category_id'] != $movement->movement_category_id){
            $movementType = MovementCategory::where('id', $data['movement_category_id'])->firstOrFail();
            $data['type'] = $movementType->type;

         }

        $movement->fill($data);


        Movement::recalculatMovimentAddedOrEdited($movement);

        $movement->save();

        return redirect()
            ->route('movement.index', $account)
            ->with('success', 'Movement saved successfully');
    }


    public function delete($movementId)
    {

        $movement = Movement::where('id', $movementId)->firstOrFail();
        $account = Account::where('id', $movement->account_id)->firstOrFail();

        $this->authorize('delete', $movement);

        $movement->delete();

        return redirect()
            ->route('movement.index', $account)
            ->with('success', 'Movement deleted successfully');
    }

    


}
