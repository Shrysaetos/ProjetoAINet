<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\AccountType;


class Account extends Model
{

	use SoftDeletes;


	protected $fillable = [
        'account_type_id', 'date', 'code', 'description', 'start_balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'current_balance', 'last_movement_date',
    ];

	public function getFormattedTypeAttribute()
    {

        $account_types = AccountType::all();

        foreach ($account_types as $type) {
            if($this->account_type_id == $type->id){
                return $type->name;
            }
        }
        
        return 'Unknown';
    }


    protected $dates = ['deleted_at'];

}
