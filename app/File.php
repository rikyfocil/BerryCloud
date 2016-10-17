<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model {     

	protected $guarded =  ['id', 'owner', 'isFolder', 'publicRead'];

	public function alias()
    {
        return $this->hasOne('App\Alias', 'idFile');
    }

    public function versions()
    {
        return $this->hasMany('App\Version', 'idFile');
    }

    public function shares()
    {
        return $this->hasMany('App\Share', 'idFile');
    }

    public function parent()
    {
        return $this->belongsTo('App\File', 'parent');
    }

    public function childs()
    {
        return $this->hasMany('App\File', 'parent');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner');
    }
}
