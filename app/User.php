<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password', 'type'
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
        switch ($this->type) {
            case '0':
                return 'Administrator';
            case '1':
                return 'Publisher';
            case '2':
                return 'Client';
        }

        return 'Unknown';
    }

    public function isAdmin()
    {
        return $this->type == '0';
    }

    public function isPublisher()
    {
        return $this->type == '1';
    }

    public function isClient()
    {
        return $this->type == '2';
    }
}
