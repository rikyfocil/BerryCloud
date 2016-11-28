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
        if(!Auth::check())
            abort(403);
        
        $sharedWithMe = Auth::user()->sharedWithMe();

        return view('home', ['files' => $sharedWithMe]);
    }

    public function trash()
    {
        $userFiles = File::onlyTrashed()->where('owner', Auth::user()->id)->get();

        return view('home', ['files' => $userFiles]);
    }
}
