<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{

    function __construct(){
        //$this->middleware('auth');
    }

    function usersLike(Request $request){

        $validator = Validator::make($request->all(), [
            'term' => 'required',
        ]);

        if ($validator->fails()) {
          abort(400);
        }

        $fq = DB::table('users')->where('email', 'like', '%' . $request->term . '%')->where('isVirtual', false)->select(['email']);

        $result = DB::table('users')->where('name', 'like', '%' . $request->term . '%')->where('isVirtual', true)->select(['name as email'])->union($fq)->get();

        return $result;
    }
    
    function usersOnlyLike(Request $request){

    	$validator = Validator::make($request->all(), [
            'term' => 'required',
        ]);

        if ($validator->fails()) {
          abort(400);
        }

    	$result = DB::table('users')->where('email', 'like', '%' . $request->term . '%')->where('isVirtual', false)->select(['email'])->get();
    	return $result;
    }


}
