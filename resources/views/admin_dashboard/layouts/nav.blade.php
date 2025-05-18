<?php

function checkPermission($name) {    
    $route_arr = auth()->user()->role->permissions;
    $route = $route_arr->where('name', $name)->count();
    if($route == 1){
        return true;
    }
    return false;
}

?>
<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ asset('kcnew/frontend/img/image_iconLogo.png') }}" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 style="color: #00b249" class="logo-text">TDQ - News</h4>
                </div>
                <div style="color: #00b249" class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
                @if(checkPermission("admin.index"))
                <li>
                    <a href="{{ route('admin.index') }}" >
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Bảng điều khiển</div>
                    </a>
                </li>
                @endif

                @if(checkPermission("admin.posts.index") || checkPermission("admin.posts.create") )
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                        </div>
                        <div class="menu-title">Bài viết</div>
                    </a>

                    <ul>
                        @if(checkPermission("admin.posts.index"))
                            <li> <a href="{{ route('admin.posts.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả bài viết</a>
                            </li>
                        @endif         

                        @if(checkPermission("admin.posts.create"))
                        <li> <a href="{{ route('admin.posts.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm bài viết mới</a>
                        </li>
                        @endif 

                    </ul>
                </li>
                @endif

                @if(checkPermission("admin.categories.index") || checkPermission("admin.categories.create") )
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-menu'></i>
                        </div>
                        <div class="menu-title">Danh mục bài viết</div>
                    </a>

                    <ul>
                        @if(checkPermission("admin.categories.index"))
                        <li> <a href="{{ route('admin.categories.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả danh mục</a>
                        </li>
                        @endif 

                        @if(checkPermission("admin.categories.create"))
                        <li> <a href="{{ route('admin.categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm danh mục mới</a>
                        </li>
                         @endif 
                    </ul>
                </li>
                @endif

                @if(checkPermission("admin.tags.index"))
                <li>
                    <a href="{{ route('admin.tags.index') }}">
                    <div class="parent-icon"><i class='bx bx-purchase-tag'></i></div>
                        <div class="menu-title">Từ khóa</div>
                    </a>
                </li>
                @endif

                @if(checkPermission("admin.comments.index") || checkPermission("admin.comments.create") )
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-comment-dots'></i>
                        </div>
                        <div class="menu-title">Bình luận</div>
                    </a>

                    <ul>
                        @if(checkPermission("admin.comments.index"))
                        <li> <a href="{{ route('admin.comments.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả bình luận</a>
                        </li>
                        @endif

                        @if(checkPermission("admin.comments.create"))
                        <li> <a href="{{ route('admin.comments.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm bình luận mới</a>
                        </li>
                        @endif
                        
                    </ul>
                </li>
                @endif

                <hr>

                @if(checkPermission("admin.roles.index") || checkPermission("admin.roles.create") )
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-key'></i>
                        </div>
                        <div class="menu-title">Phân Quyền</div>
                    </a>

                    <ul>
                         @if(checkPermission("admin.roles.index"))
                        <li> <a href="{{ route('admin.roles.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả quyền</a>
                        </li>
                        @endif

                        @if(checkPermission("admin.roles.create"))
                        <li> <a href="{{ route('admin.roles.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm quyền mới</a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(checkPermission("admin.users.index") || checkPermission("admin.users.create") )
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-user'></i>
                        </div>
                        <div class="menu-title">Tài khoản</div>
                    </a>

                    <ul>

                        @if(checkPermission("admin.users.index"))
                        <li> <a href="{{ route('admin.users.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả tài khoản</a>
                        </li>
                        @endif

                        @if(checkPermission("admin.users.create"))
                        <li> <a href="{{ route('admin.users.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm tài khoản mới</a>
                        </li>
                        @endif
                        
                    </ul>
                </li>
                @endif

                @if(checkPermission("admin.contacts"))
                <li>
                    <a href="{{ route('admin.contacts') }}" >
                    <div class="parent-icon"><i class='bx bx-mail-send'></i></div>
                        <div class="menu-title">Liên hệ</div>
                    </a>
                </li>
                @endif
                
                @if(checkPermission("admin.setting.edit"))
                <li>
                    <a href="{{ route('admin.setting.edit') }}" >
                    <div class="parent-icon"><i class='bx bx-info-square'></i></div>
                        <div class="menu-title">Cài đặt</div>
                    </a>
                </li>
                @endif

                <hr>
 
                <li>
                    <a href="{{ route('home') }}" >
                    <div class="parent-icon"><i class='bx bx-pointer'></i></div>
                        <div class="menu-title">Trang chủ</div>
                    </a>
                </li>

           
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->