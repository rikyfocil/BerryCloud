<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller
{
    function usersLike($str){
    	$result = DB::table('users')->where('email', 'like', 'root@example.com%')->select(['email', 'id'])->get()
    	return $result;
    }

    function userID(){

    }
}
