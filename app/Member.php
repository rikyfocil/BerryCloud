<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = ['id'];

    public function group(){
    	return $this->belongsTo('App\Group', 'idGroup');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'idMember');
    }
}
