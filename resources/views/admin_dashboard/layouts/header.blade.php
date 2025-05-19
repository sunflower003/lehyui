<!-- Header giả lập -->
<header>
    <h1>Quản trị hệ thống</h1>
</header>
<div class="gradient_bar"></div>
<nav class="header_nav">
    <a href="/admin" class="logo">
        <i class="ri-checkbox-blank-circle-line"></i>LehyUI Admin
    </a>
    <div class="menu">
        <ul class="nav_links">
            <li><a href="{{ route('admin.posts.index') }}" class="link">Quản lý bài viết</a></li>
            <li><a href="{{ route('admin.posts.create') }}" class="link">Thêm bài viết</a></li>
            <li><a href="{{ route('admin.categories.index') }}" class="link">Quản lý hạng mục</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="link">Quản lý user</a></li>
            <li><a href="{{ route('admin.comments.index') }}" class="link">Quản lý bình luận</a></li>
        </ul>
        <a href="/" class="btn">
            <div class="btn_text">Về trang chính</div>
            <div class="btn_shadow"></div>
        </a>
    </div>
</nav>
