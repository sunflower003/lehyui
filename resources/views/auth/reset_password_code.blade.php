@extends('layouts.app')
@section('title', 'Verify Code')

@section('content')
<div class="login_container">
  <div class="login_left">...</div>
  <div class="login_right">
    <div class="login_form-container">
      <h2 class="login_title">Enter Code</h2>
      <form method="POST" action="{{ route('password.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <label class="login_label">Enter code sent to your email</label>
        <input class="login_input" type="text" name="token" required />
        <button class="login_button" type="submit">Verify</button>
      </form>
    </div>
  </div>
  <div class="login_right_2"></div>
</div>
@endsection
