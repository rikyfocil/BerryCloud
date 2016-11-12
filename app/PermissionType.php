<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Share;

class PermissionType extends Model
{

	private $writePermissionID = 2;

    protected $guarded = ['id'];

    public function shares()
    {
        return $this->hasMany('App\Share', 'idPermissionType');
    }

    public function hasWritePermission(){
    	return $this->id <= $this->writePermissionID;
    }
}
