<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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
        switch ($this->type) {
            case '1':
                return 'Bank Account';
            case '2':
                return 'Pocket Money';
            case '3':
                return 'Paypal Account';
            case '4':
                return 'Credit Card';
            case '5':
                return 'Meal Card';
        }

        return 'Unknown';
    }


    protected $dates = ['deleted_at'];

}
