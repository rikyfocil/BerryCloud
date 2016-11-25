<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\UserType;
use App\User;

class PermissionsController extends Controller 
{


	public function getUser()
	{
		if(!Auth::check())
			return redirect()->route('home');

		if(Auth::user()->idUserType != 3)
			return redirect()->route('home');

		return view('permissions.permissions', ['users' => User::where('isVirtual',false)->with("permission")->get(), 'permission_types' => UserType::all()]);

	}

	public function changePermission(Request $request, $id)
	{
		if(!Auth::check())
			return redirect()->route('home');

		if(Auth::user()->idUserType != 3)
			return redirect()->route('home');

		$change_permission = User::findOrFail($id);
		$change_permission->idUserType = $request["permission"];
		$change_permission->save();

		return redirect()->route("getUser");
		

	}


}
