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
            <div class="avatar_header_container">
                <img src="{{ $user->avatar_path }}" class="profile_avatar" />
                <div class="dropdown">
                    <div class="dropdown_header">
                        <img src="{{ $user->avatar_path }}" class="profile_avatar" />
                        <p class="username">{{ $user->username }}</p>
                    </div>
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="dropdown_link">Admin Dashboard</a>
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