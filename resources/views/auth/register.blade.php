@extends('layouts.app')

@section('title', 'Sign up to LehyUI')

@section('content')
<div class="register_container">
  <div class="register_left">
    <p class="register_left_text">@lehyUI</p>
    <video autoplay muted loop>
      <source src="https://cdn.dribbble.com/uploads/48292/original/30fd1f7b63806eff4db0d4276eb1ac45.mp4?1689187515" type="video/mp4">
    </video>
  </div>

  <div class="register_right">
    <div class="register_form-container">
      <h2 class="register_title">Sign up to LehyUI</h2>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <label class="register_label">Username</label>
        <input class="register_input" type="text" name="username" value="{{ old('username') }}" required />

        <label class="register_label">Password</label>
        <input class="register_input" type="password" name="password" required />

        <label class="register_label">Confirm Password</label>
        <input class="register_input" type="password" name="password_confirmation" required />

        <label class="register_label">Gender</label>
        <div class="register_gender">
          <label><input type="radio" name="sex" value="male" {{ old('sex') === 'male' ? 'checked' : '' }} required /> Male</label>
          <label><input type="radio" name="sex" value="female" {{ old('sex') === 'female' ? 'checked' : '' }} required /> Female</label>
        </div>

        <button class="register_button" type="submit">Sign Up</button>
      </form>

      <div class="register_terms">
        By creating an account you agree with our
        <a href="#">Terms of Service</a>, <a href="#">Privacy Policy</a>
      </div>

      <div class="register_signin">
        Already have an account?
        <a href="{{ route('login') }}">Sign In</a>
      </div>
    </div>
  </div>

  <div class="register_right_2"></div>
</div>
@endsection
