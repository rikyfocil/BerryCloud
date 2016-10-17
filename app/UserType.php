<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $guarded = ['id'];

    public function users(){
    	return $this->hasMany('App\User', 'idUserType');
    }
}

