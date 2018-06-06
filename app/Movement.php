<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\MovementCategory;
use App\Account;

class Movement extends Model
{
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


    public static function recalculateMovementsBalance (Account $account, $value){

        $accountMovements = Movement::where('account_id', $account->id)->orderBy('date', 'asc')->get();
        
        $counter = 0;

        foreach ($movements as $movement) {
            if ($counter == 0){
                $movement->start_balance = $value;
                $movement->end_balance = $value+$movement->value;
                $lastMovementAltered = $movement;
                $movement->save();
            } else {

                $movement->start_balance = $lastMovementAltered->end_balance;
                $movement->end_balance = $lastMovementAltered->end_balance+$movement->value;
                $lastMovementAltered = $movement;
                $movement->save();
                $account->updateCurrentBalance($movement->end_balance);
            }

            $counter++;

            
        }

    }



    public static function recalculateMovementsDate (Movement $movement){

        $account = Account::where('id', $movement->account_id)->firstOrFail();

        $accountMovements = Movement::where('account_id', $account->id)->orderBy('date', 'asc')->get();;

        $counter = 0;

            //get movements after the movement date
            foreach ($accountMovements as $accountMovement) {

                //if the insert movement's date is bigger then the analised moviment's date
                if ($movement->date > $accountMovement->date){
                    if ($counter == 0){
                        $movement->start_balance = $accountMovement->end_balance;
                        $movement->end_balance = $accountMovement->end_balance + $movement->value;
                        $movement->save();
                        $lastMovementAltered = $movement;
                    } else {
                        $accountMovement->start_balance = $lastMovementAltered->end_balance;
                        $accountMovement->end_balance = $lastMovementAltered->end_balance + $accountMovement->value;
                        $lastMovementAltered = $accountMovement;
                        $accountMovement->save();
                        $account->updateCurrentBalance($accountMovement->end_balance);
                    }

                    $counter++;
                }
            }
    }


    




    public $timestamps = false;

}
