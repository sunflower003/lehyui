<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Nếu chưa đăng nhập
        if (!$user) {
            $user = (object) [
                'username' => 'Guest',
                'avatar' => asset('img/avatar_default.jpg') // ảnh mặc định
            ];
        } else {
            // Nếu đã đăng nhập
            $user->avatar = $user->avatar
                ? asset($user->avatar)  // ảnh đã upload
                : asset('img/avatar_default.jpg'); // ảnh mặc định
        }

        return view('home', compact('user'));
    }
}
