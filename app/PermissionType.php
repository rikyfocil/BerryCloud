<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionType extends Model
{
    protected $guarded = ['id'];

    public function shares()
    {
        return $this->hasMany('App\Share', 'idPermissionType');
    }
}
