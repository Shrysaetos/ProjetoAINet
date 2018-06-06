<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\MovementCategory;

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

        $movements = Movement::where('account_id', $account->id)->orderBy('date', 'asc')->get();
        
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


    




    public $timestamps = false;

}
