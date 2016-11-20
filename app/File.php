<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
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

    public function ensureUserWritePermission(User $user) {

        if($this->isOwner())
            return true;

        if($this->ensureUserWritePermissionToSingleUser($user))
            return true;

        $groups = $user->groupMemberships()->get();
        Log::warning(json_encode($groups));
        foreach ($groups as $memebrship) {
            if($this->ensureUserWritePermissionToSingleUser($memebrship->group()->first()->representativeUser()->first()))
                return true;
        }

        return false;
    }

    private function ensureUserWritePermissionToSingleUser(User $user){

        $id = $user->id;

        $share = Share::where('idFile', $this->id)
            ->where('idUser', $id)->where('dueDate', '>', Carbon::now())->first();

        // We search for not expired shares
        if( $share != null && $share->permissionType()->first()->hasWritePermission() )
                return true;
            
        $share = Share::where('idFile', $this->id)->where('idUser', $id)
                ->where('dueDate', null)->first();
        
        // Last we check for not expiring shares
        if($share != null && $share->permissionType()->first()->hasWritePermission())
            return true;

        $parent = $this->parent()->first();

        if(!$parent)
            return false;

        return $parent->ensureUserWritePermissionToSingleUser($user);
    }

    public function ensureUserReadPermission(User $user){
        if($this->isOwner())
            return true;

        if($this->ensureUserReadPermissionToSingleUser($user))
            return true;

        $groups = $user->groupMemberships()->get();
        Log::warning(json_encode($groups));
        foreach ($groups as $memebrship) {
            if($this->ensureUserReadPermissionToSingleUser($memebrship->group()->first()->representativeUser()->first()))
                return true;
        }

        return false;
    }

    private function ensureUserReadPermissionToSingleUser(User $user){
        
         if($this->publicRead)
            return true;

        if(!$user){

            $parent = $this->parent()->first();

            if($parent)
                return $parent->ensureUserReadPermissionToSingleUser($user);
            
            return false;
        }

        $id = $user->id;
        // We search for not expired shares
        if(Share::where('idFile', $this->id)->where('idUser', $id)
            ->where('dueDate', '>', Carbon::now())->exists())
                return true;
        
        // Last we check for not expiring shares
        if(Share::where('idFile', $this->id)->where('idUser', $id)
            ->where('dueDate', null)->exists())
                return true; 

        $parent = $this->parent()->first();

        if($parent)
            return $parent->ensureUserReadPermissionToSingleUser($user);
        
        return false;        
    }
}
