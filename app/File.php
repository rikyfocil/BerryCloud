<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class File extends Model {     

    use SoftDeletes{
        forceDelete as concludeForceDelete;
    }
	
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

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

    public function forceDelete()
    {

        if($this->isFolder){

            $files = $this->childs()->get();

            // We delete recursively
            foreach ($files as $file) {
                $file->forceDelete();
            }
        }
        else{
            $versions = $this->versions()->get();

            // To delete dependendencies and ensure a clean file system we delete
            // the versions before the file
            foreach ($versions as $version) {
                $version->delete();
            }
        }

        return $this->concludeForceDelete();
    }

    public function currentVersion()
    {
        if($this->isFolder)
            return $this->updated_at;

        return $this->versions()->orderBy('updated_at','desc')->first()->updated_at;

    }

    
    public function hierarchy(){

        $hierarchy = [$this];
        $file = $this;

        while($file->parent){
            $file = $file->parent()->first();
            array_unshift($hierarchy, $file);
        }

        return $hierarchy;
    }

    public function isOwner() {
        return Auth::check() && $this->owner()->first()->id == Auth::user()->id;
    }

}
