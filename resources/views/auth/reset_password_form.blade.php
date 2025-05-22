@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="login_container">
  <div class="login_left">...</div>
  <div class="login_right">
    <div class="login_form-container">
      <h2 class="login_title">Reset Password</h2>
      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <label class="login_label">New Password</label>
        <input class="login_input" type="password" name="password" required />
        <label class="login_label">Confirm Password</label>
        <input class="login_input" type="password" name="password_confirmation" required />
        <button class="login_button" type="submit">Update Password</button>
      </form>
    </div>
  </div>
  <div class="login_right_2"></div>
</div>
@endsection
