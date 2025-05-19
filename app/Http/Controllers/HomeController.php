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
                'avatar_path' => asset('img/5ee082781b8c41406a2a50a0f32d6aa6.jpg') // ảnh mặc định
            ];
        } else {
            // Nếu đã đăng nhập
            $user->avatar_path = $user->avatar
                ? asset('storage/' . $user->avatar)  // ảnh đã upload
                : asset('img/5ee082781b8c41406a2a50a0f32d6aa6.jpg'); // ảnh mặc định
        }

        return view('home', compact('user'));
    }
}
