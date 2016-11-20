<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = ['id'];

    public function representativeUser(){
    	return $this->belongsTo('App\User', 'idGenerated');
    }

    public function owner(){
    	return $this->belongsTo('App\User', 'idOwner');
    }

    public function members()
    {
        return $this->hasMany('App\Member', 'idGroup');
    }
}
