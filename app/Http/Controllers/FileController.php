<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Version;
use App\PermissionType;
use App\Share;
use App\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

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

		return $file->ensureUserReadPermission(Auth::user());
 	}

	private function ensureUserWritePermission(\App\File $file) {

		if(!Auth::check())
			return false;

		return $file->ensureUserWritePermission(Auth::user());
	}


	private function ensureUserOwnerPermission(\App\File $file) {

  		if(!Auth::check())
  			return false;

 		$id = Auth::user()->id;

		// If the user is the owner then he has full access
		if($file->owner == $id)
		  return true;

		return false;
  	}

	private function responseDownload(Version $version){
  		$path = $version->path;

		$exists = Storage::disk('local')->exists($path);

		if(!$exists){
			Log::critical('The version requested is not present on the disk but is on
				the db. path:' . $path);
			abort(500);
		}

	 	return response()->download(storage_path("app/" . $path), $version->file->
	 		first()->name);
  	}

	function uploadForm(Request $request){
		$params = array();

		if($request->has('parent')){

			$file = \App\File::where('id', $request->parent)->firstOrFail();

			if(!$file->isFolder)
				abort(400);

			if(!$this->ensureUserWritePermission($file))
				abort(403);

			$params['parent'] =  $request->parent;
		}

		return view('file.upload', $params);
	}

	function show(Request $request, $fileId){

		$file = \App\File::where('id', $fileId)->firstOrFail();

		if(!$this->ensureUserReadPermission($file))
			abort(403);

		$versions = Version::where('idFile', $file->id)
			->orderBy('updated_at', 'desc')->get();

		$sharing_types = [];

		$shareTable = PermissionType::all();
		foreach ($shareTable as $share) {
			$sharing_types[$share->id] = $share->name;
		}

		$params = ['file' => $file, 'versions' => $versions, 'sharing_types' => $sharing_types];

		if($file->isFolder){
			$params['parent'] = $file;
			$params['files'] = $file->childs()->get();
			return view('home', $params);
		}
		else
			return view('file.show', $params);

	}

	function upload(Request $request){

		if(!$this->ensureUserFolder())
			abort(500);

		$this->validate($request, [
    	    'file' => 'required|file',
    	    'parent' => 'numeric|exists:files,id'
	    ]);

		$file = $request->file('file');

    	if (!$file->isValid()) {
			return back()->withErrors([
				'upload' =>'There was a problem while uploading the file'
			]);
		}

		$parent = null;
		$userID = Auth::user()->id;

		if($request->has('parent')){

			$parentFile = \App\File::find($request->parent);
			if(!$parentFile->isFolder){
				abort(400);
			}

			if(!$this->ensureUserWritePermission($parentFile))
				abort(403);

			$parent = $parentFile->id;
			$userID = $parentFile->owner;
		}

		// We remove the extension where we save the file
		$path = $file->storeAs( $userID,
			preg_replace('/\\.[^.\\s]{1,5}$/', '', $file->hashName()) );

		$name = $file->getClientOriginalName();

		$fileModel = \App\File::where('name', $name)->where('owner', $userID)
			->where('parent', $parent)->first();

		// If there is not a model available. Therefore we need to create one
		if($fileModel == null){

			// There is a really special case where the user upload a deleted
			// file. We fix it here
			$del = \App\File::onlyTrashed()->where('name', $name)
			->where('owner', $userID)->where('parent', $parent)->first();

			if($del != null){
				$del->forceDelete();
			}

			$fileModel = new \App\File;
			$fileModel->name = $name;
			$fileModel->owner =  $userID;
			$fileModel->parent = $parent;

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

		if($file->isFolder){
			abort(501); // TBD, should zip a folder somehow and download it
		}
		else{
			$version = Version::where('idFile', $file->id)
				->orderBy('updated_at', 'desc')->first();

			if($version == null){
				Log::critical('There is a file without versions');
				abort(500);
			}

			return $this->responseDownload($version);
		}

	}

	function downloadVersion(Request $request, $file_id, $version_id){
		//First we validate that the file and version actually exist
		$file = \App\File::findOrFail($file_id);
		$version = \App\Version::findOrFail($version_id);

		//Then we validate that the version and file actually match
		if($file->id != $version->idFile){
			//They don't match and therefore the requested file version does not exist
			abort(404);
		}

		if(!$this->ensureUserReadPermission($file))
			abort(403);

		return $this->responseDownload($version);
	}

	function uploadVersion(Request $request, $file_id){

		$this->validate($request, [
    	    'file' => 'required|file',
	    ]);

	   	$uploadedFile = $request->file('file');

	    if (!$uploadedFile->isValid()) {
			return back()->withErrors([
				'upload' =>'There was a problem while uploading the file version'
			]);
		}

		// Even if we validated on the get request we can't ensure that the
		// user played fair and didn´t change the id. We must validate.
		$fileModel = \App\File::where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserWritePermission($fileModel))
			abort(403);

		if($fileModel->isFolder)
			abort(400);

		// We remove the extension where we save the file

		$path = $uploadedFile->storeAs( $fileModel->owner,
			preg_replace('/\\.[^.\\s]{1,5}$/', '', $uploadedFile->hashName()));

		$version = new Version;
		$version->idFile = $fileModel->id;
		$version->path = $path;

		if(!$version->save()){
			Log::critical('Could not save version.');
			abort(500);
		}

		return redirect()->route('file.show', [$fileModel->id])
			->with('success', 'Version uploaded successfully');
	}

	function uploadVersionGet(Request $request, $file_id){

		$file = \App\File::where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserWritePermission($file))
			abort(403);

		if($file->isFolder){
			abort(400);
		}

		return view('file.version.upload', ['file'=>$file]);
	}

	function restoreVersion(Request $request, $file_id, $version_id){

		/*
		Restoring a version is an easy process. The only thing that needs to be
		done is changing the updated_at field of the version to match the moment
		when the user request it to become the main version. This way we don't lose
		any data. Not even when was the version created and the ones above it.

		There is no need of validating folders as they don´t create versions
		*/

		$file = \App\File::where('id', $file_id)->firstOrFail();
		$version = Version::where('id', $version_id)->firstOrFail();

		// We cross check file and version
		if( $file->id != $version->file()->first()->id )
			abort(404);

		if(!$this->ensureUserWritePermission($file))
			abort(403);

		$version->setUpdatedAt(Carbon::now());
		$version->save();
		return redirect()->route('file.show', [$version->file()->first()->id])
			->with('success', 'Version restored');
	}

	function restoreFile(Request $request, $file_id){

		/*
		Restoring a file means that we will remove the deleted_at field from it.
		Laravel can manage this process for us, but we take care that we only
		restore a trashed file in the query.

		Folders can work the same way as they are just entries of a file without versions
		*/

		$file = \App\File::onlyTrashed()->where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserWritePermission($file))
			abort(403);

		$file->restore();

		return redirect()->route('file.show', [$file->id])->with('success', 'File restored');
	}

	function delete(Request $request, $file_id){

		$file = \App\File::where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserOwnerPermission($file))
			abort(403);

		$file->delete();

		return redirect()->route('home')->with('success', 'File moved to trash');
	}

	function deleteHard(Request $request, $file_id){
		/*
			This is a method where the user can opt for destroying his file for good.
			As this is as a really dangerous operation with only allowing it from the
			owner of the file.
		*/
		$file = \App\File::where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserOwnerPermission($file))
			abort(403);

		if(!$file->forceDelete()){
			Log::alert('Could not delete file ' . $file->id);
			abort(500);
		}

		return redirect()->route('home')->with('success', 'The file is gone');
	}

	function deleteVersion(Request $request, $file_id, $version_id){

		// This also requires owner permission access as the file is going to
		// be deleted
		$file = \App\File::where('id', $file_id)->firstOrFail();
		$version = \App\Version::where('id', $version_id)->firstOrFail();

		// As usual, we cross check the version with the file
		if( $file->id != $version->file()->first()->id )
			abort(404);

		if(!$this->ensureUserOwnerPermission($file))
			abort(403);

		// Now we validate that there is at least 2 versions
		if($file->versions()->count() == 1){
			return back()
				->with('error', 'This file only has one version. To remove it delete the entire file first');
		}

		if(!$version->delete()){
			Log::alert('Could not delete version ' . $version->id);
			abort(500);
		}

		return redirect()->route('file.show', [$file->id])
			->with('success', 'The version is gone');
	}

	/* ==== Sharing permission === */

	// Get the people that the file is shared with
	function sharedWith($file_id){
		$file = \App\File::where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserOwnerPermission($file))
			abort(403);

		$shares =  DB::table('shares')->join('permission_types', 'shares.idPermissionType', 'permission_types.id')->join('users', 'shares.idUser', 'users.id')->select('shares.id', 'users.email', 'users.name as uname', 'permission_types.name', 'shares.dueDate', 'shares.idPermissionType as share_type', 'users.isVirtual')->where('shares.idFile', $file_id)->get();

		foreach ($shares as $share) {

			if($share->isVirtual)
				$share->email = $share->uname;

			$share->uname = null;
		}


		return $shares;
	}

	// Share the file
	function shareWith(Request $request, $file_id){
		$file = \App\File::where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserOwnerPermission($file))
			abort(403);

		$this->validate($request, [
    	    'user' => 'required',
    	   	'idPermissionType' => 'required|numeric|exists:permission_types,id',
    	   	'dueDate' => 'date'
	    ]);

		$user = User::where('email', $request->user)->where('isVirtual', false)->first();

		if($user == null){
			$user = User::where('name', $request->user)->where('isVirtual', true)->firstOrFail();
		}

		$share = Share::firstOrNew(['idUser' => $user->id , 'idFile' => $file_id]);

		if($request->has('dueDate'))
			$share->dueDate = $request->dueDate;

		$share->idPermissionType = $request->idPermissionType;

		if(!$share->save()){
			Log::critical('Could not save share');
			abort(500);
		}

        return redirect()->route('file.show',$file_id);
	}

	// Delete sharing
	// Share the file
	function deleteShare($file_id, $share_id){

		$share = Share::where('id', $share_id)->firstOrFail();

		if($share->idFile != $file_id){
			abort(404);
		}

		$file = $share->file()->firstOrFail();

		if(!$this->ensureUserOwnerPermission($file))
			abort(403);


		if(!$share->delete()){
			Log::critical('Could not delete share');
			abort(500);
		}

		return ['message' => 'success', 'id' => $share->id];
	}

	// The last section on the sharing engine is about making the file public and making it private again

	function makePublic($file_id){

		$file = \App\File::where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserOwnerPermission($file)){
			abort(403);
		}

		if($file->publicRead){
			// The file was already public so the user should not be here
			Log::info('Attempted to make public an already public file');
			abort(404);
		}

		$file->publicRead = true;
		$file->save();

		return redirect()->route('file.show', [$file->id])
			->with('success', 'The file is open to the entire world now!');
	}

	function makePrivate($file_id){

		$file = \App\File::where('id', $file_id)->firstOrFail();

		if(!$this->ensureUserOwnerPermission($file)){
			abort(403);
		}

		if(!$file->publicRead){
			// The file was already private so the user should not be here
			Log::info('Attempted to make private an already private file');
			abort(404);
		}

		$file->publicRead = false;
		$file->save();

		return redirect()->route('file.show', [$file->id])
			->with('success', 'The file is protected again!');
	}


	/*========================= Folder engine ============================= */

	function createFolder(Request $request){

		$validator = Validator::make($request->all(), [
    	    'name' => 'required|alpha_num',
    	    'parent' => 'numeric|exists:files,id'
	    ]);

        if ($validator->fails()) {
            return ['message' => $validator->messages(), 'success' => false];
        }

		if(!Auth::check()){
			abort(403);
		}

		$parent = null;
		$owner = Auth::user()->id;


		if($request->has('parent')){
			$parentFile = \App\File::where('id', $request->parent)->firstOrFail();

			if (!$parentFile->isFolder) {
            	return ['message' => 'Bad request', 'success' => false];
			}

			if(!$this->ensureUserWritePermission($parentFile)){
	            return ['message' => 'Forbidden', 'success' => false];
			}

			$owner = $parentFile->owner;
			$parent = $parentFile->id;
		}

		$exists = \App\File::where(['name'=>$request->name, 'parent'=>$parent, 'owner'=>$owner])->count();

		if($exists){
			return ['message' => 'File or folder already exists by that name', 'success' => false];
		}

		$folder = new \App\File();
		$folder->isFolder = true;
		$folder->name = $request->name;
		$folder->owner = $owner;
		$folder->parent = $parent;

		$success = $folder->save();

		if (!$success) {
			Log::critical("Could not create folder. Please debug");
		}

        if ($parent) {
            return redirect()->route('file.show',$parent);
        } else {
            return redirect()->route('home');
        }
	}

}
