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
                    $movement->end_balance = (($lastBalance-$movement->value) * 100 )/100.0;


                } else if ($movement->type == 'revenue'){
                    $movement->end_balance = (($lastBalance+$movement->value) * 100) /100.0;
                    
                }

                $movement->save();
                $lastBalance = $movement->end_balance;
               
        }
            $account->current_balance = $lastBalance;
            $account->save();
            
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
                    }

                    $account->current_balance = $movement->end_balance;
                    $account->save();

                    $counter++;
                }
            }
    }


    

    public function movementCategory (){
        $this->hasOne(MovementCategory::class, 'id', 'movement_category_id');
    }



    public $timestamps = false;

}
