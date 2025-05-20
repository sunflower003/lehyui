<nav class="sidebar-nav">
    <div class="px-3 mb-3 text-xs font-semibold text-gray-400 uppercase">Tổng quan</div>
    <ul class="list-none p-0 m-0">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.posts.index') }}" class="nav-link">
                <i class="fas fa-newspaper"></i>
                <span>Danh sách bài viết</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.posts.create') }}" class="nav-link">
                <i class="fas fa-plus-circle"></i>
                <span>Thêm bài viết</span>
            </a>
        </li>
    </ul>
    
    <div class="px-3 mt-6 mb-3 text-xs font-semibold text-gray-400 uppercase">Quản lý</div>
    <ul class="list-none p-0 m-0">
        <li>
            <a href="{{ route('admin.categories.index') }}" class="nav-link">
    <i class="fas fa-folder"></i>
    <span>Danh mục</span>
</a>

        </li>
        <li>
           <a href="{{ route('admin.comments.index') }}" class="nav-link">

                <i class="fas fa-comments"></i>
                <span>Bình luận</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="nav-link">
                <i class="fas fa-users"></i>
                <span>Người dùng</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="fas fa-cog"></i>
                <span>Cài đặt</span>
            </a>
        </li>
        <li class="mt-6">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Trang chủ</span>
                </a>
        </li>
    </ul>
</nav>
