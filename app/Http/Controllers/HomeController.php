<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\File;
use App\Share;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userFiles = File::where('owner', Auth::user()->id)->where('parent', null)->get();

        return view('home', ['files' => $userFiles]);
    }

    // The files passed here also recieve the owner parsed
    public function sharedWith()
    {

        $sharedWithMe = Share::where('idUser', Auth::user()->id)->where( function($query){ 
            $query->where('dueDate', null)->orWhere('dueDate', '>', Carbon::now() );
        } )->get();

        $fileArray = [];

        foreach ($sharedWithMe as $currentShare) {
            $file = $currentShare->file()->first();
            array_push($fileArray, $file);
        }

        return view('home', ['files' => $fileArray]);
    }

    public function trash()
    {
        $userFiles = File::onlyTrashed()->where('owner', Auth::user()->id)->get();

        return view('home', ['files' => $userFiles]);
    }
}
