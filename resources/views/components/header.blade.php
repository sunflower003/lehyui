<div class="gradient_bar"></div>

<nav class="header_nav">
    <a href="/" class="logo">
        <i class="ri-checkbox-blank-circle-line"></i>LehyUI
    </a>

    <div class="menu">
        <ul class="nav_links">
            <li><a href="/" class="link">Home</a></li>
            <li><a href="#" class="link">Crypto</a></li>
            <li><a href="#" class="link">Stocks</a></li>
            <li><a href="#" class="link">Mobile</a></li>
            <li><a href="#" class="link">PC</a></li>
            <li><a href="#" class="link">Health</a></li>
            <li><a href="#" class="link">All Categories</a></li>
        </ul>

        <a href="{{ route('login') }}" class="btn">
            <div class="btn_text">Get Started</div>
            <div class="btn_shadow"></div>
        </a>


        @if(isset($user) && $user)
        <div class="avatar_header_container">
            <img src="{{ $user->avatar_path ?? asset('img/avatar_default.jpg') }}" alt="avatar" class="avatar">
            <div class="dropdown">
                <div class="dropdown_header">
                    <img src="{{ $user->avatar_path ?? asset('img/avatar_default.jpg') }}" alt="avatar" class="avatar">
                    <p class="username">{{ $user->username }}</p>
                </div>
                @if(Auth::check())
                        <a href="{{ route('profile.settings') }}" class="dropdown_link">Settings</a>
                <hr />
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown_link" style="background: none; border: none; padding: 0; cursor: pointer;">Sign out</button>
                </form>
                @endif
            </div>
        </div>
        @else
        <div class="avatar_header_container">
            <img src="{{ asset('img/avatar_default.jpg') }}" alt="avatar" class="avatar">
            <div class="dropdown">
                <div class="dropdown_header">
                    <img src="{{ asset('img/avatar_default.jpg') }}" alt="avatar" class="avatar">
                    <p class="username">Khách</p>
                </div>
                <a href="{{ route('login') }}" class="dropdown_link">Đăng nhập</a>
            </div>
        </div>
        @endif
    </div>
</nav>
