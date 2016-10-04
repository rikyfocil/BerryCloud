<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $guarded = ['id', 'path', 'date'];

    public function file(){
    	return $this->belongsTo('App\File', 'idFile');
    }
}