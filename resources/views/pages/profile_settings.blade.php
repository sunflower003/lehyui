@extends('layouts.app')

@section('title', 'Profile Settings - LehyUI')

@section('content')

@include('components.donate')
@include('components.header')

<main>
  <section class="container profile_wrapper" data-active-tab="{{ $active_tab ?? session('active_tab', 'profile_general') }}">
    <div class="profile_sidebar">
      <ul class="profile_menu">
        <li class="profile_menu-item active">General</li>
        <li class="profile_menu-item">Edit Profile</li>
        <li class="profile_menu-item">Password</li>
        <li class="profile_menu-item">Donate</li>
        <li class="profile_menu-item">Email Notifications</li>
      </ul>
    </div>

    <!-- General Tab -->
    <div class="profile_tab-content" id="profile_general">
      <h2 class="profile_title">{{ $user->username }} / <span>General</span></h2>
      <p class="profile_description">Your public profile information</p>

      <div class="profile_avatar-block">
        <img src="{{ $user->avatar_path }}" class="profile_avatar profile_avatar_large" alt="{{$user->username}}'s avatar">
      </div>

      <form class="profile_form">
        <div class="profile_form-group">
          <label class="profile_label">Username</label>
          <input type="text" class="profile_input no-caret" value="{{$user->username}}" readonly />

          <label class="profile_label">Email</label>
          <input type="text" class="profile_input no-caret" value="{{$user->email}}" readonly />

          <label class="profile_label">Sex</label>
          <p class="profile_note">{{$user->sex}}</p>
        </div>

        <div class="profile_form-group">
          <label class="profile_label">Google Sign-In</label>
          <button type="button" class="profile_button profile_google profile_button_3">Google</button>
          <p class="profile_note">Use Google to access your LehyUI account.</p>
        </div>

        <div class="profile_form-group">
          <label class="profile_label">Disable ads</label>
          <p class="profile_note">With a Pro account you can disable ads across the site.</p>
        </div>
      </form>

      {{-- Xoá tài khoản --}}
      @if (session('delete_error'))
        <p style="color: red; margin-bottom: 0.5rem;">{{ session('delete_error') }}</p>
      @endif
      @if (session('delete_success'))
        <p style="color: green; margin-bottom: 0.5rem;">{{ session('delete_success') }}</p>
      @endif

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

    <!-- Edit Profile Tab -->
    <div class="profile_tab-content" id="profile_edit" style="display: none;">
      <h2 class="profile_title">{{ $user->username }} / <span>Edit Profile</span></h2>
      <p class="profile_description">Update your username and avatar</p>

      @if (session('success') && session('active_tab') === 'profile_edit')
        <p style="color: green; margin-bottom: 0.5rem;">{{ session('success') }}</p>
      @endif

      @if ($errors->any() && session('active_tab') === 'profile_edit')
        <div style="color: red; margin-top: 0.5rem;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
      @endif

      <form class="profile_form" method="POST" action="{{ route('profile.update.info') }}" enctype="multipart/form-data">
        @csrf
        <div class="profile_avatar-block">
          <img src="{{ $user->avatar_path }}" class="profile_avatar profile_avatar_large" alt="{{$user->username}}'s avatar">
          <div class="profile_avatar-buttons">
            <label for="avatar-upload" class="upload-btn">Upload new picture</label>
            <span id="file-name" style="font-style: italic;"></span>
            <input type="file" id="avatar-upload" name="avatar" accept="image/*" style="display: none;">
          </div>
        </div>
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('avatar-upload');
            const fileName = document.getElementById('file-name');

            input.addEventListener('change', function () {
              if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
              } else {
                fileName.textContent = '';
              }
            });
          });
        </script>

        <div class="profile_form-group">
          <label class="profile_label">Username</label>
          <input type="text" name="username" class="profile_input" value="{{ $user->username }}" />
        
          <label class="profile_label">Email</label>
          <input type="email" name="email" class="profile_input" value="{{ $user->email }}" />
        </div>

        <button type="submit" class="profile_button profile_save">Save Profile</button>
      </form>
    </div>

    <!-- Password Tab -->
    <div class="profile_tab-content" id="profile_password" style="display: none;">
        <h2 class="profile_title">{{ $user->username }} / <span>Password</span></h2>
        <p class="profile_description">Change your password</p>

        @if (session('error') && session('active_tab') === 'profile_password')
            <p style="color: red; margin-bottom: 0.5rem;">{{ session('error') }}</p>
        @endif
        @if (session('success') && session('active_tab') === 'profile_password')
            <p style="color: green; margin-bottom: 0.5rem;">{{ session('success') }}</p>
        @endif

        @if ($errors->any() && session('active_tab') === 'profile_password')
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

    <!-- Payouts Tab -->
    <div class="profile_tab-content" id="profile_payouts" style="display: none;">
      <h2 class="profile_title">{{ $user->username }} / <span>Donate</span></h2>
      <p class="profile_description">Your donation history</p>
      <table class="table-donate-history">
          <thead>
          <tr>
            <th>Amount</th>
            <th>Time</th>
            <th>Content</th>
            <th>Bank Account Number</th>
            <th>Bank</th>
            <th>ID Transaction</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
              @forelse($donations as $d)
                <tr>
                  <td data-label="Amount">{{ number_format($d->amount) }} {{ $d->currency }}</td>
                  <td data-label="Time">{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                  <td data-label="Content">{{ $d->description }}</td>
                  <td data-label="Bank Account Number">0929561600</td>
                  <td data-label="Bank">
                      <span style="display: inline-flex; align-items: center;">
                        <img src="{{ asset('img/mbbank-logo-5.png') }}" alt="MB" style="width:24px;height:24px;vertical-align:middle;margin-right:8px;border-radius:6px;box-shadow:0 2px 8px #eee;">
                        <span style="font-weight: 600; color: #1e2262; margin-left: 2px;">MB</span>
                      </span>
                  </td>
                  <td data-label="ID Transaction">{{ $d->order_code }}</td>
                  <td data-label="Status">
                      @if($d->status === 'success')
                          <span class="donate-status-success">Success</span>
                      @elseif($d->status === 'pending')
                          <span class="donate-status-pending">Pending</span>
                      @elseif($d->status === 'cancelled')
                          <span class="donate-status-cancelled">Cancelled</span>
                      @else
                          <span class="badge bg-secondary">{{ ucfirst($d->status) }}</span>
                      @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7">No donation history</td>
                </tr>
              @endforelse
        </tbody>
      </table>
      @if ($donations->hasPages())
      <div class="pagination-wrapper" style="margin-top: 16px; display: flex; justify-content: center;">
        {{ $donations->appends(['active_tab' => 'profile_payouts'])->links() }}
      </div>
      @endif
    </div>

<!-- Email Notifications Tab -->
<div class="profile_tab-content" id="profile_email_notifications" style="display: none;">
    <h2 class="profile_title">{{ $user->username }} / <span>Email Notifications</span></h2>
    <p class="profile_description">Email notifications</p>
    <ul class="email-notification-list">
        @forelse($email_notifications as $noti)
            <li class="email-notification-item {{ $noti->is_read ? '' : 'unread' }}">
                <div class="noti-icon">
                    @if($noti->type == 'new_post')
                        <i class="fas fa-newspaper"></i>
                    @elseif($noti->type == 'donate_thank')
                        <i class="fas fa-gift"></i>
                    @elseif($noti->type == 'reply_comment')
                        <i class="fas fa-reply"></i>
                    @else
                        <i class="fas fa-info-circle"></i>
                    @endif
                </div>
                <div class="noti-content">
                    @if(($noti->type == 'new_post' || $noti->type == 'reply_comment') && $noti->post_id)
                        <a href="{{ route('posts.show', ['id' => $noti->post_id]) }}#comments" class="noti-title" style="text-decoration: none; color: #252653;">
                            {{ $noti->title }}
                        </a>
                    @else
                        <div class="noti-title">{{ $noti->title }}</div>
                    @endif
                    <div class="noti-desc">{{ $noti->body }}</div>
                    <div class="noti-time">{{ \Carbon\Carbon::parse($noti->created_at)->diffForHumans() }}</div>
                </div>
            </li>
        @empty
            <li class="email-notification-empty">No email notifications</li>
        @endforelse
    </ul>
    @if ($email_notifications->hasPages())
        <div class="pagination-wrapper" style="margin-top: 12px; display: flex; justify-content: center;">
            {{ $email_notifications->appends(['active_tab' => 'profile_email_notifications'])->links() }}
        </div>
    @endif
</div>

  </section>
</main>
@include('components.footer')
@endsection
