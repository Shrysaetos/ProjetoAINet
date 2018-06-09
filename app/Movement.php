<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\MovementCategory;
use App\Account;

class Movement extends Model
{


    protected $fillable = [
        'account_id', 'date', 'movement_category_id', 'description', 'value', 'type', 'end_balance', 'start_balance', 'document_id', 'created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 
    ];




    public function getFormattedCategoryAttribute()
    {

        $movement_categories = MovementCategory::all();

        foreach ($movement_categories as $category) {
            if($this->movement_category_id == $category->id){
                return $category->name;
            }
        }
        
        return 'Unknown';
    }


    public static function recalculateMovementsBalance (Account $account){

        $accountMovements = Movement::where('account_id', $account->id)->orderBy('date', 'asc')->orderBy('created_at', 'asc')->get();
        $lastBalance = $account->start_balance;


        foreach ($accountMovements as $movement) {

                $movement->start_balance = $lastBalance;
                

                if ($movement->type == 'expense'){
                    $movement->end_balance = bcmul($lastBalance-$movement->value, 100, 0)/100.0;


                } else if ($movement->type == 'revenue'){
                    $movement->end_balance =  bcmul($lastBalance+$movement->value, 100, 0) /100.0;
                    
                }

                $movement->save();
                $lastBalance = $movement->end_balance;
               
        }
            $account->current_balance = $lastBalance;
            $account->save();
            

            
        }

        



    public static function recalculatMovimentAddedOrEdited (Movement $movement){

        $account = Account::where('id', $movement->account_id)->firstOrFail();

        $accountMovements = Movement::where('account_id', $account->id)->where('date', '>', $movement->date)->orderBy('date', 'asc')->orderBy('created_at', 'asc')->get();

        $movementBefore = Movement::where('account_id', $account->id)->where('date', '<', $movement->date)->orderBy('date', 'desc')->orderBy('created_at', 'desc')->first();

        

        if (!is_null($movementBefore) ){
                $movement->start_balance = $movementBefore->end_balance;

                if ($movement->type == 'expense'){
                    $movement->end_balance = bcmul($movementBefore->end_balance-$movement->value, 100, 0)/100.0;


                } else if ($movement->type == 'revenue'){
                    $movement->end_balance =  bcmul($movementBefore->end_balance+$movement->value, 100, 0) /100.0;
                    
                }

        }



        if (!is_null($accountMovements) ){

            $lastBalance = $movement->end_balance;

            foreach ($accountMovements as $accountMovement) {

                $accountMovement->start_balance = $lastBalance;
                
                if ($accountMovement->type == 'expense'){
                    $accountMovement->end_balance = bcmul($lastBalance-$accountMovement->value, 100, 0)/100.0;


                } else if ($accountMovement->type == 'revenue'){
                    
                    $accountMovement->end_balance =  bcmul($lastBalance+$accountMovement->value, 100, 0) /100.0;
                    
                }

                 $lastBalance = $accountMovement->end_balance;
                 $accountMovement->save();


                $account->current_balance = $accountMovement->end_balance;
                $account->save();

                }
            }
            
    }


    

    public function movementCategory (){
        $this->hasOne(MovementCategory::class, 'id', 'movement_category_id');
    }



    public $timestamps = false;

}
