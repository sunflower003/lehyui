<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm() {
        $user = auth()->user();
        return view('auth.login', compact('user'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Gửi session cho toast
            return redirect()->route('home')->with('login_success', 'Login Successfully!');
        }

        // Gửi error cho toast
        return back()->withErrors([
            'invalid' => 'Invalid Information. Please try again.',
        ]);
    }

    public function showRegisterForm() {
        $user = auth()->user();
        return view('auth.register', compact('user'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'sex' => 'required|in:male,female'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'sex' => $request->sex,
            'role' => 'user', // mặc định user
            'avatar' => 'img/avatar_default.jpg', // đường dẫn avatar mặc định
        ]);

        // Gửi session cho toast
        return redirect('/login')->with('success', 'Register Successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home'); // ← về trang chủ
    }
}
