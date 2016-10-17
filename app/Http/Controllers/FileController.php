<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Version;
use App\Share;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

// $checked = $request->has('newsletter') ? true: false;

class FileController extends Controller{

    /*     
    This method is provided to make sure that the user has a folder before
    performing operations on it. This method should always return true and
    in case it doesn't, it means that the user is a guest or that there was
    a critical error. 
    The caller should act accordingly
    */
 	private function ensureUserFolder() {
  
  	if(Auth::check()){

  		$id = Auth::user()->id;
			$exists = Storage::disk('local')->exists($id);
		
			if(!$exists){

				if(!Storage::disk('local')->makeDirectory($id)){

					Log::critical("Could not create directory for user " . $id );
					return false;
				}

				return true;
			}

			if(!File::isDirectory(storage_path("app/" . $id))){

				Log::critical("User directory is not a directory for user: " . $id);
				return false;
			}

			return true;	
	  } // Auth::check

	  Log::info('upload rejected as the user is not authenticaded');
  	return false;
  }

  private function ensureUserReadPermission(\App\File $file) {
  	
  	if($file->publicRead)
  		return true;

  	if(Auth::check()){
  		$id = Auth::user()->id;
  		
  		// If the user is the owner then he has full access
  		if($file->owner == $id)
  		  return true;

  		// We search for not expired shares
  		if(Share::where('idFile', $file->id)->where('idUser', $id)
  			->where('dueDate', '>', Carbon::now())->exists())
  				return true;
  		
  		// Last we check for not expiring shares
  		if(Share::where('idFile', $file->id)->where('idUser', $id)
  			->where('dueDate', null)->exists())
  				return true;

	  } // Auth::check

  	return false;
  }

  function uploadForm(Request $request){

		return view('file.upload');
	}

	function show(Request $request, $fileId){

		abort(501);
		return "";
	}

	function upload(Request $request){

		if(!$this->ensureUserFolder())
			abort(500);

		$this->validate($request, [
    	    'file' => 'required|file',
	    ]);

		$file = $request->file('file');

    	if (!$file->isValid()) {
			return back()->withErrors([
				'upload' =>'There was a problem while uploading the file'
			]);
		}

		$userID = Auth::user()->id;

		// We remove the extension where we save the file
		$path = $file->storeAs( $userID, 
			preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName()) );

		$name = $file->getClientOriginalName();

		$fileModel = \App\File::where('name', $name)->where('owner', $userID)
			->first();

		// If there is not a model available. Therefore we need to create one
		if($fileModel == null){

			$fileModel = new \App\File;
			$fileModel->name = $name;
			$fileModel->owner =  $userID;

			if(!$fileModel->save()){
				Log::critical('Could not save file model');
				abort(500);
			}
		}

		$version = new Version;
		$version->idFile = $fileModel->id;
		$version->path = $path;
		
		if(!$version->save()){
			Log::critical('Could not save version.');
			abort(500);
		}

		return redirect()->route('home')
			->with('success', 'File uploaded successfully');
	}

	function download(Request $request, $fileID){

		$file = \App\File::where('id', $fileID)->firstOrFail();

		if(!$this->ensureUserReadPermission($file))
			abort(403);

		$version = Version::where('idFile', $file->id)
			->orderBy('created_at', 'desc')->first();

		if($version == null){
			Log::critical('There is a file without versions');
			abort(500);
		}

		$path = $version->path;

		$exists = Storage::disk('local')->exists($path);

		if(!$exists){
			Log::critical('The version requested is not present on the disk but is on 
				the db. path:' . $path);
			abort(500);
		}

	 	return response()->download(storage_path("app/" . $path), $file->name);
	}

	function downloadVersion(Request $request, $file_id, $version_id){

		abort(501);
		return "";
	}

	function uploadVersion(Request $request, $file_id){

		if(!$this->ensureFolder())
			abort(500);

		abort(501);
		return "";
	}

	function restore(Request $request, $version_id){

		abort(501);
		return "";
	}

	function delete(Request $request, $file_id){

		abort(501);
		return "";
	}
	
	function deleteHard(Request $request, $file_id){

		abort(501);
		return "";
	}

	function deleteVersion(Request $request, $file_id, $version_id){

		abort(501);
		return "";
	}

}
