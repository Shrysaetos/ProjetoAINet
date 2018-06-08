<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\AccountType;


class Account extends Model
{

	use SoftDeletes;


	protected $fillable = [
        'account_type_id', 'date', 'code', 'description', 'start_balance', 'owner_id', 'current_balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'last_movement_date',
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


    public function user(){
        return $this->belongsTo(User::class, 'id', 'owner_id');
    }

    public function movements(){
        return $this->hasMany(Movements::class, 'account_id', 'id');
    }

    public function type(){
        return $this->hasOne(AccountType::class, 'id', 'account_type_id');
    }



    protected $dates = ['deleted_at'];

    public $timestamps = false;

}
