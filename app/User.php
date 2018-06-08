<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'profile_photo', 'admin', 'blocked'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // formatted_type
    public function getFormattedTypeAttribute()
    {
        switch ($this->admin) {
            case '0':
                return 'Administrator';
            case '1':
                return 'Normal';
        }

        return 'Unknown';
    }

    public function isAdmin()
    {
        return $this->admin == 1;
    }

    public function isClient()
    {
        return $this->admin == 0;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }


    public function isAccountOwner (Account $account){
        if ($this->id == $account->owner_id){
            return true;
        }
        return false;
    }

    public static function getAllBlockedUsers()
    {
        return User::where('blocked', '=', 1);
    }

    public static function getAllNotBlockedUsers()
    {
        return User::where('blocked', '!=', 1);
    }

    public function getProfilePhoto()
    {
        if (isset($this->profile_photo)) {
            return $this->profile_photo;
        }
        return 'default.jpg';
    }


    public function accounts(){
        return $this->hasMany(Account::class, 'owner_id', 'id');
    }


}
