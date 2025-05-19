@extends('layouts.app')

@section('title', 'LehyUI Blog')

@section('content')
<!-- Nút donate bên phải -->
<div class="donate-button" id="donateToggle">DONATE</div>

<!-- Form Donate -->
<div class="donate-form" id="donateForm">
    <div class="donate-header">
        <span>Support Us</span>
        <button id="closeDonate">&times;</button>
    </div>
    <p>Your support helps us grow and keep building awesome things!</p>

    <div class="qr-container">
        <img src="{{ asset('img/qr.jpg') }}" alt="Donate QR Code" />
        <p>Scan this QR code to donate</p>
    </div>

    <div class="donate-info">
        <p><strong>Bank:</strong> MB Bank</p>
        <p><strong>Account:</strong> 67850060092003</p>
        <p><strong>Holder:</strong> Nguyen Le Huy</p>
    </div>
</div>

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


        <div class="avatar_header_container">
            <img src="{{ $user->avatar_path }}" alt="avatar" class="avatar">
            <div class="dropdown">
                <div class="dropdown_header">
                    <img src="{{ $user->avatar_path }}" alt="avatar" class="avatar">
                    <p class="username">{{ $user->username }}</p>
                </div>
                <a href="/profile" class="dropdown_link">Settings</a>
                <hr />
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown_link" style="background: none; border: none; padding: 0; cursor: pointer;">Sign out</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main>
<div class="container header_container">
    <header>
        <h1>Inside Design: Stories and interviews</h1>
        <p>Subscribe to learn about new product features, the latest in technology, and updates.</p>
        <form action="">
            <input type="email" placeholder="Enter your email" required>
            <button>Subscribe</button>
        </form>
    </header>
</div>

<div class="container recent_container">
    <h2 class="title_head">Recent blog posts</h2>
    <div class="grid_head">
        <div class="card_head ontop">
            <img src="{{ asset('img/img2.jpg') }}" alt="picture">
            <div class="card_details">
                <p class="author_time">Olivia Rhye <i class="ri-checkbox-blank-circle-fill"></i> 20 Jan 2024</p>
                <h2 class="title_card">Conversations with London Makr & Co.<i class="ri-arrow-right-up-line"></i></h2>
                <p class="subtitle">We sat down with Makr & Co. to find out how they've used Lehy UI to 2x their revenue.</p>
                <div class="tags">
                    <span class="tag">Design</span>
                    <span class="tag">Research</span>
                    <span class="tag">Interviews</span>
                </div>
            </div>
        </div>

        <!-- Các bài viết khác (bạn có thể loop từ database sau này) -->
        <div class="card_head">
            <img src="{{ asset('img/img8.jpg') }}" alt="picture">
            <div class="card_details">
                <p class="author_time">Phoenix Baker <i class="ri-checkbox-blank-circle-fill"></i> 19 Jan 2024</p>
                <h2 class="title_card">A Relentless Pursuit of Perfection in Product Design</h2>
                <p class="subtitle">"I began to notice that there was a sharp contrast between well-made...</p>
                <div class="tags">
                    <span class="tag">Design</span>
                    <span class="tag">Research</span>
                </div>
            </div>
        </div>
        <!-- ... -->
    </div>
</div>

<!-- All Posts Grid -->
<div class="container all_container">
    <h2 class="title_head">All blog posts</h2>
    <div class="grid_posts">
        <a href="/post" class="grid_card">
            <img src="{{ asset('img/img5.jpg') }}" alt="image">
            <div class="card_details">
                <p class="author_time">Alec Whitten <i class="ri-checkbox-blank-circle-fill"></i> 17 Jan 2024</p>
                <h2 class="title_card">A Continually Unfolding History - Hillview<i class="ri-arrow-right-up-line"></i></h2>
                <p class="subtitle">The much-lauded work of Made by Hand...</p>
                <div class="tags">
                    <span class="tag">Design</span>
                    <span class="tag">Architecture</span>
                </div>
            </div>
        </a>
        <!-- ... -->
    </div>
</div>

<!-- Pagination + Footer -->
<div class="container pagination">
    <span class="previous">← Previous</span>
    <ul>
        <li class="current">1</li>
        <li>2</li>
        <li>3</li>
        <li class="dot">...</li>
        <li>8</li>
        <li>9</li>
        <li>10</li>
    </ul>
    <span class="after">Next →</span>
</div>

<footer>
    <div class="gradient_bar"></div>
    <div class="container2 footer_container">
        <div class="sign_up">
            <div class="content">
                <h1>Sign up to our newsletter</h1>
                <p>Stay up to date with the latest news, announcements, and articles.</p>
            </div>
            <form action="">
                <input type="email" placeholder="Enter your email" required>
                <button>Subscribe</button>
            </form>
        </div>
        <!-- Footer Grid Copy/Paste ở đây -->
    </div>
</footer>
</main>
@endsection
