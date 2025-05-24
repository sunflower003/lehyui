@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div class="login_container">
  <div class="login_left">...</div>
  <div class="login_right">
    <div class="login_form-container">
      <h2 class="login_title">Forgot Password</h2>
      @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif
      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label class="login_label">Email</label>
        <input class="login_input" type="email" name="email" required />
        <button class="login_button" type="submit">Send Code</button>
      </form>
      <div class="login_signup">
        <a href="{{ route('login') }}">Back to login</a>
      </div>
    </div>
  </div>
  <div class="login_right_2"></div>
</div>
@endsection
