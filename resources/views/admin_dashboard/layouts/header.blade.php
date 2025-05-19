<div class="flex items-center">
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 rounded-full py-1 px-3 transition-colors">
            <img src="https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=fff" class="w-8 h-8 rounded-full" alt="User">
            <span class="text-sm font-medium">Admin</span>
            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
        </button>
        
        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-user mr-2"></i> Hồ sơ
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-cog mr-2"></i> Cài đặt
            </a>
            <div class="border-t border-gray-200 my-1"></div>
            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
            </a>
        </div>
    </div>
</div>

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

