<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Group;
use App\Member;

use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    
    function __construct(){
    	$this->middleware('auth');
    }

    private function ensureUserAcces(Group $group){

    	if(!Auth::check())
    		return false;

    	return Auth::user()->id == $group->idOwner;
    }

	function index(Request $request){
		$groups = Group::where('idOwner', Auth::user()->id)->get();
		return view('group.index', ['groups'=>$groups]);
	}

	function show(Request $request, $idGroup){
		$group = Group::where('id', $idGroup)->firstOrFail();
		$user = $group->representativeUser()->first();
		$group->name = $user->name;
		$members = $group->members()->get();
		return view('group.show', ['group' => $group, 'members' => $members]);
	}

	function store(Request $request){

		// We validate that the user dont have a group with the same name
		$this->validate($request, [
    	    'name' => 'required|string',
	    ]);

	    $groups = Group::where('idOwner', Auth::user()->id)->get();

	    foreach ($groups as $group) {
	    	if($group->representativeUser()->first()->name == $request->name){
	    		return back()->withInput()->withErrors(['name' => 'The group already exists']);
	    	}
	    }

		$user = new User();
		$user->name = $request->name;
		//Lets ensure we have a unique email for the virtual user
		$user->email = Auth::user()->id . $request->name . str_random(3) . '@BerryCloud.com';
		$user->isVirtual = true;
		// The password will be random as we dont want the user to be able to login
		$user->password = str_random(40);
		$user->save();

		Group::create(['idOwner' => Auth::user()->id, 'idGenerated' => $user->id]);
		return redirect()->route('groups.index')->with('success', 'Group created successfully');
	}

	function destroy(Request $request, $idGroup){

		$group = Group::where('id', $idGroup)->firstOrFail();

		if(!$this->ensureUserAcces($group)){
			abort(403);
		}

		$user = $group->representativeUser()->first();
		$user->delete();

		$redirect = redirect()->route('groups.index');

		if(!$group->delete()){
			$redirect->withErrors(['error' => 'The group could not be deleted']);
		}
		else{
			$redirect->with(['success' => 'The group was deleted']);
		}

		return $redirect;
	}

	function addMember(Request $request, $idGroup){
		
		$this->validate($request, [
    	    'email' => 'required|email|exists:users,email'
	    ]);

		$user = User::where('email', $request->email)->firstOrFail();
		$group = Group::where('id', $idGroup)->firstOrFail();

		if(!$this->ensureUserAcces($group)){
			abort(403);
		}

		if($user->isVirtual){	
			return back()->withErrors(['email' => 'A virtual user must not be part of a group']);
		}

		$count = Member::where('idGroup', $idGroup)->where('idMember', $user->id)->count();
		if($count != 0){
			return back()->withErrors(['email' => 'User is already in the group']);
		}

		Member::create(['idGroup' => $idGroup, 'idMember' => $user->id]);
		return redirect()->route('groups.show', [$idGroup])->with('success', 'User added successfully');

	}
	
	function removeMember(Request $request, $idGroup, $idMember){
		
		$member = Member::where('id', $idMember)->firstOrFail();
		$group = Group::where('id', $idGroup)->firstOrFail();

		if($member->idGroup != $group->id)
			abort(404);

		if(!$this->ensureUserAcces($group))
			abort(403);


		$redirect = redirect()->route('groups.show', [$idGroup]);

		if(!$member->delete()){
			$redirect->withErrors(['error' => 'The member could not be removed from group']);
		}
		else{
			$redirect->with(['success' => 'The member was removed']);
		}
		
		return $redirect;
	}

}
