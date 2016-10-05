<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $guarded = ['id'];

    public function permissionType(){    	
        return $this->belongsTo('App\PermissionType', 'idPermissionType');
    }

    public function file(){    	
        return $this->belongsTo('App\File', 'idFile');
    }

     public function sharedWith(){    	
        return $this->belongsTo('App\User', 'idUser');
    }

}
