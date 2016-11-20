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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function files(){
        return $this->hasMany('App\File', 'owner');
    }

    public function sharedFiles(){
        return $this->hasMany('App\Share', 'idUser');
    }


     public function permission(){
        return $this->hasOne('App\UserType', 'id', 'idUserType');

    }

    public function groupMemberships(){
        return $this->hasMany('App\Member', 'idMember');
    }

    public function ownedGroups(){
        return $this->hasMany('App\Group', 'idOwner');

    }

}