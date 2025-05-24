<div class="gradient_bar"></div>

<nav class="header_nav">
    <a href="/" class="logo">
        <i class="ri-checkbox-blank-circle-line"></i>LehyUI
    </a>

    <div class="menu">
        <ul class="nav_links">
            <li><a href="/" class="link">Home</a></li>
            @foreach ($headerCategories as $category)
            <li><a href="{{ route('category.posts', $category->id) }}" class="link">{{ $category->name }}</a></li>
            @endforeach
            <li><a href="{{ route('categories.all') }}" class="link">All Categories</a></li>
        </ul>

        @if (!Auth::check())
            <a href="{{ route('login') }}" class="btn">
                <div class="btn_text">Get Started</div>
                <div class="btn_shadow"></div>
            </a>
        @endif

        @if(Auth::check())

            {{-- Notification bell --}}
            <div class="notif_lehy" id="notificationBell">
                <i class="ri-notification-3-line"></i>

                <div class="notif_dropdown hidden_notif" id="notificationDropdown">
                    <div class="notif_header">
                        <span>Notifications</span>
                    </div>

                    <div class="notif_list">
                        @forelse ($headerNotifications as $noti)
                            <div class="notif_item {{ $noti->is_read ? '' : 'notif_highlighted' }}">
                                <div class="notif_icon">
                                    @if($noti->type === 'new_post')
                                        <i class="fas fa-newspaper"></i>
                                    @elseif($noti->type === 'donate_thank')
                                        <i class="fas fa-gift"></i>
                                    @elseif($noti->type === 'reply_comment')
                                        <i class="fas fa-reply"></i>
                                    @else
                                        <i class="fas fa-info-circle"></i>
                                    @endif
                                </div>
                                <div class="notif_text">
                                    <p class="notif_title">
                                        @if(
                                            ($noti->type === 'new_post' || $noti->type === 'reply_comment')
                                            && $noti->post_id
                                        )
                                            <a href="{{ route('posts.show', ['id' => $noti->post_id]) }}#comments"
                                               style="text-decoration: none; color: #252653;">
                                                {{ $noti->title }}
                                            </a>
                                        @else
                                            {{ $noti->title }}
                                        @endif
                                    </p>
                                    <p class="notif_body">{{ $noti->body }}</p>
                                    <span class="notif_time">{{ $noti->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="notif_item no_notif">
                                <div class="notif_icon"><i class="fas fa-bell-slash"></i></div>
                                <div class="notif_title">No notifications</div>
                            </div>
                        @endforelse
                    </div>

                    <div class="notif_footer">
                        <a href="{{ route('profile.settings', ['active_tab' => 'profile_email_notifications']) }}">
                            View all notifications
                        </a>
                    </div>
                </div>
            </div>

            {{-- Avatar + dropdown --}}
            <div class="avatar_header_container">
                <img src="{{ $user->avatar_path }}" class="profile_avatar" />
                <div class="dropdown">
                    <div class="dropdown_header">
                        <img src="{{ $user->avatar_path }}" class="profile_avatar" />
                        <p class="username">{{ $user->username }}</p>
                    </div>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="dropdown_link" target="_blank">Admin Dashboard</a>
                        <hr />
                    @endif
                    <a href="{{ route('profile.settings') }}" class="dropdown_link">Settings</a>
                    <hr />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown_link" style="background: none; border: none; padding: 0; cursor: pointer;">Sign out</button>
                    </form>
                </div>
            </div>
        @endif

    </div>
</nav>
