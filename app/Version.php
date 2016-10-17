<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;


class Version extends Model
{
    protected $guarded = ['id', 'path', 'date'];

    public function file(){
    	return $this->belongsTo('App\File', 'idFile');
    }

    public function delete(){

    	// We just double check just to make sure
    	if(!Auth::check()){
    		Log::critical('Not loged user was allowed to request a version deletion');
    		abort(500);
    	}

        $file = \App\File::withTrashed()
            ->where('id', $this->idFile)->first();
    	// We get info before deleting
    	$filename = $file->name;
    	$file_id = $file->id;
    	$version_id = $this->id;

    	$count = \App\Version::where('path', $this->path)->count(); 
    	$removing = ($count == 1);

    	if($removing){
    		if(!Storage::disk('local')->delete($this->path)){
    			Log::error("Could not delete version file " . $this->id);
    			abort(500);
    		}
    	}

    	Log::notice("Version removal notice. The version  $version_id  of the file $filename with id $file_id was removed by user " . Auth::user()->email . ". The file was" . ($removing ? " " : " not ") . "removed from the system");

    	return parent::delete();
    }
}