<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($id)
    {
        $user = User::findOrFail($id);
        $currentUser = User::find(Auth::user()->id);
        //dd($currentUser);
        
        $followUser = $currentUser->following()->toggle($user->profile);

        return $followUser;
    }
}
