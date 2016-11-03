<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{
    function usersLike(Request $request){

    	$validator = Validator::make($request->all(), [
            'term' => 'required',
        ]);

        if ($validator->fails()) {
          abort(400);
        }

    	$result = DB::table('users')->where('email', 'like', '%' . $request->term . '%')->select(['email'])->get();
    	return $result;
    }
}
