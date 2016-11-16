<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request, User $user)
    {
        return view('user.profile.index', [
            'user' => $user,
        ]);
    }
}
