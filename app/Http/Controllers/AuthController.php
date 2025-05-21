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
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $credentials = [
        $loginField => $request->username,
        'password' => $request->password,
    ];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Thêm kiểm tra mail notification chưa đọc
        $unreadMailCount = \App\Models\EmailNotification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->count();

        if ($unreadMailCount > 0) {
            return redirect()->route('home')
                ->with('login_success', 'Đăng nhập thành công!')
                ->with('mail_notification',
                    "<i class='fas fa-envelope-open-text'></i>Bạn có <strong>{$unreadMailCount}</strong> thông báo email mới!
                     <a href='" . route('profile.settings', ['active_tab' => 'profile_email_notifications']) . "'>Xem ngay</a>"
                );
        } else {
            return redirect()->route('home')
                ->with('login_success', 'Đăng nhập thành công!');
        }
    }

    return back()->withErrors([
        'invalid' => 'Thông tin đăng nhập không chính xác.',
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'sex' => 'required|in:male,female'
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sex' => $request->sex,
            'role' => 'user',
            'avatar' => 'img/avatar_default.jpg',
        ]);

        return redirect('/login')->with('success', 'Đăng ký thành công! Hãy đăng nhập nhé.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
