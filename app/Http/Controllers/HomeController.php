<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();

        if (!$authUser) {
            $user = (object) [
                'username' => 'Guest',
                'avatar_path' => asset('img/avatar_default.jpg')
            ];
        } else {
            $user = $authUser;

            $user->avatar_path = ($user->avatar === 'avatar_default.jpg' || $user->avatar === null)
                ? asset('img/avatar_default.jpg')
                : asset('storage/avatars/' . $user->avatar);

        }

        return view('home', compact('user'));
    }
}