<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\UserType;
use App\User;


class PermissionsController extends Controller 
{


	public function getUser()
	{
		if(!Auth::check())
			abort(403);

		if(Auth::user()->idUserType != 3)
			abort(403);

		return view('permissions.permissions', ['users' => User::where('isVirtual',false)->with("permission")->get(), 'permission_types' => UserType::all()]);

	}

	public function changePermission(Request $request, $id)
	{
		if(!Auth::check())
			abort(403);

		if(Auth::user()->idUserType != 3)
			abort(403);


		$this->validate($request, [
				'permission'=> 'required', 		
			]);
		$new_permission = $request['permission'];

		$change_permission = User::findOrFail($id);
		$change_permission->idUserType = $new_permission;
		$change_permission->save();


		return redirect()->route("getUser");
		

	}


}
