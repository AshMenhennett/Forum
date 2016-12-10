<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        $user = $request->user();

        $topics = $user->topics()->orderBy('created_at', 'desc')->get();

        return view('home', [
            'topics' => $topics,
        ]);
    }
}
