@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')

@include('components.donate')
@include('components.header')

<main>
  <section class="container profile_wrapper" data-active-tab="{{ session('active_tab', 'profile_general') }}">
    <div class="profile_sidebar">
      <ul class="profile_menu">
        <li class="profile_menu-item active">General</li>
        <li class="profile_menu-item">Edit Profile</li>
        <li class="profile_menu-item">Password</li>
        <li class="profile_menu-item">Social Profiles</li>
        <li class="profile_menu-item">Company</li>
        <li class="profile_menu-item">Payouts</li>
        <li class="profile_menu-item">Email Notifications</li>
        <li class="profile_menu-item">Billing</li>
        <li class="profile_menu-item">Sessions</li>
        <li class="profile_menu-item">Applications</li>
        <li class="profile_menu-item">Data Export</li>
      </ul>
    </div>

    <div class="profile_tab-content" id="profile_general">
      <h2 class="profile_title">{{ $user->username }} / <span>General</span></h2>
      <p class="profile_description">Your public profile information</p>

      <div class="profile_avatar-block">
        <img src="{{ $user->avatar_path }}" class="avatar">
        <div class="profile_avatar-buttons">
          <span class="profile_button_3" style="cursor: default;">{{ ucfirst($user->sex) }}</span>
        </div>
      </div>

      <form class="profile_form" method="POST" action="{{ route('profile.delete.account') }}">
        @csrf
        @method('DELETE')
        <div class="profile_form-group">
          <label class="profile_label">Confirm your password</label>
          <input type="password" name="password" class="profile_input" required />
        </div>
        <button type="submit" class="profile_button profile_danger" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
      </form>
    </div>

    <div class="profile_tab-content" id="profile_edit" style="display: none;">
      <h2 class="profile_title">{{ $user->username }} / <span>Edit Profile</span></h2>
      <p class="profile_description">Update your username and avatar</p>

      <form class="profile_form" method="POST" action="{{ route('profile.update.info') }}" enctype="multipart/form-data">
        @csrf
        <div class="profile_avatar-block">
          <img src="{{ $user->avatar_path }}" class="avatar">
          <div class="profile_avatar-buttons">
            <input type="file" name="avatar" class="profile_button profile_button_2" accept="image/*">
          </div>
        </div>

        <div class="profile_form-group">
          <label class="profile_label">Username</label>
          <input type="text" name="username" class="profile_input" value="{{ $user->username }}" />
        </div>

        <button type="submit" class="profile_button profile_save">Save Profile</button>
      </form>
    </div>

    <div class="profile_tab-content" id="profile_password" style="display: none;">
        <h2 class="profile_title">{{ $user->username }} / <span>Password</span></h2>
        <p class="profile_description">Change your password</p>

        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <div style="color: red; margin-top: 0.5rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form class="profile_form" method="POST" action="{{ route('profile.update.password') }}">
            @csrf

            <div class="profile_form-group">
                <label class="profile_label">Old password</label>
                <input type="password" name="old_password" class="profile_input" required />
            </div>

            <div class="profile_form-group">
                <label class="profile_label">New password</label>
                <input type="password" name="new_password" class="profile_input" required />
            </div>

            <div class="profile_form-group">
                <label class="profile_label">Confirm new password</label>
                <input type="password" name="new_password_confirmation" class="profile_input" required />
            </div>
            <button type="submit" class="profile_button profile_save">Change Password</button>
        </form>
    </div>
    </section>
  @include('components.footer')
</main>
@endsection
