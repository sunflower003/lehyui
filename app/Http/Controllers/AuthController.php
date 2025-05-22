<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\EmailNotification;
use App\Models\PasswordReset;

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
        $unreadMailCount = $unreadMailCount = EmailNotification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->count();

        if ($unreadMailCount > 0) {
            return redirect()->route('home')
                ->with('login_success', 'Successfully logged in!')
                ->with('mail_notification',
                    "<i class='fas fa-envelope-open-text'></i>You have <strong>{$unreadMailCount}</strong> new notifications.
                     <a href='" . route('profile.settings', ['active_tab' => 'profile_email_notifications']) . "'>View</a>"
                );
        } else {
            return redirect()->route('home')
                ->with('login_success', 'Successfully logged in!');
        }
    }

    return back()->withErrors([
        'invalid' => 'Invalid credentials. Please try again.',
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

        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showForgotForm() {
        return view('auth.forgot_password');
    }

    public function sendResetCode(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = mt_rand(100000, 999999); // 6 số
        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('emails.password_reset_mail', ['token' => $token], function($message) use ($request) {
            $message->to($request->email)->subject('Reset Password - LehyUI');
        });

        return redirect()->route('password.code')->with('email', $request->email);
    }

    public function showCodeForm(Request $request) {
        $email = session('email') ?? $request->email;
        if (!$email) return redirect()->route('password.request');
        return view('auth.reset_password_code', compact('email'));
    }
    
    public function verifyCode(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'token' => 'required'
    ]);
    $record = PasswordReset::where('email', $request->email)
        ->where('token', $request->token)
        ->where('created_at', '>=', Carbon::now()->subMinutes(15))
        ->first();
    if ($record) {
        // Đúng mã, cho sang đổi pass
        return view('auth.reset_password_form', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    } else {
        return back()->withErrors(['token' => 'Mã không đúng hoặc đã hết hạn!']);
    }
    }

    public function updatePassword(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'token' => 'required',
        'password' => 'required|min:6|confirmed'
    ]);

    $record = PasswordReset::where('email', $request->email)
        ->where('token', $request->token)
        ->where('created_at', '>=', Carbon::now()->subMinutes(15))
        ->first();

    if (!$record) {
        return back()->withErrors(['token' => 'Mã không hợp lệ hoặc đã hết hạn!']);
    }

    $user = User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();

    PasswordReset::where('email', $request->email)->delete();

    return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công! Hãy đăng nhập.');
}

}
