@extends('admin_dashboard.layouts.app')

@section('page-title', 'Quản lý người dùng')

@section('wrapper')
<div class="w-full max-w-4xl mx-auto mt-10 px-2">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold flex items-center">
                <i class="fas fa-users text-indigo-500 mr-2"></i> Danh sách người dùng
            </h1>
            <p class="text-gray-500 mt-1">Quản lý tất cả user hệ thống</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <div class="flex">
                <div class="py-1"><i class="fas fa-check-circle text-green-500 mr-3"></i></div>
                <div>
                    <p>{{ session('success') }}</p>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5" data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Đóng</span>
                    <i class="fas fa-times text-green-500"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Search and Filter -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-end">
            <!-- Search -->
            <div class="flex-grow w-full">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5"
                        placeholder="Tìm kiếm người dùng...">
                </div>
            </div>

            <!-- Lọc giới tính -->
            <select name="sex"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 w-full md:w-auto">
                <option value="">Tất cả giới tính</option>
                <option value="male" {{ request('sex') == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ request('sex') == 'female' ? 'selected' : '' }}>Nữ</option>
            </select>

            <!-- Sort -->
            <select name="sort"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 w-full md:w-auto">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                <option value="username" {{ request('sort') == 'username' ? 'selected' : '' }}>Tên (A-Z)</option>
            </select>

            <button type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">
                Lọc
            </button>
        </div>
    </form>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        @if($users->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Avatar</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên đăng nhập</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Giới tính</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày tạo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $users->firstItem() + $index }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <img src="{{ $user->avatar && $user->avatar != 'avatar_default.jpg' ? asset('storage/avatars/'.$user->avatar) : asset('img/avatar_default.jpg') }}"
                                alt="{{ $user->username }}" class="h-10 w-10 object-cover rounded-full border">
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $user->username }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm">
                            @if($user->sex === 'male')
                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded">Nam</span>
                            @else
                                <span class="inline-block px-2 py-1 bg-pink-100 text-pink-800 rounded">Nữ</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm">
                            @if($user->role === 'admin')
                                <span class="inline-block px-2 py-1 bg-red-100 text-red-800 rounded">Admin</span>
                            @else
                                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-800 rounded">User</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y') : '' }}
                        </td>
                        <td class="px-4 py-4 text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 p-2 rounded-md transition-colors" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Bạn chắc chắn muốn xoá user này?')" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-2 rounded-md transition-colors" title="Xoá">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div>
                    <p class="text-sm text-gray-700">
                        Hiển thị <span class="font-medium">{{ $users->firstItem() }}</span> đến <span class="font-medium">{{ $users->lastItem() }}</span> của <span class="font-medium">{{ $users->total() }}</span> người dùng
                    </p>
                </div>
                <div>
                    {{ $users->appends(request()->all())->links() }}
                </div>
            </div>
        @else
            <div class="p-8 text-center">
                <div class="inline-flex rounded-full bg-yellow-100 p-4 mb-4">
                    <div class="rounded-full bg-yellow-200 p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                </div>
                @if(request()->hasAny(['search', 'sex', 'sort']))
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Không tìm thấy kết quả</h3>
                    <p class="text-gray-500 mb-6">Không có người dùng nào khớp với tiêu chí tìm kiếm hoặc bộ lọc của bạn.</p>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-md transition-colors">
                        <i class="fas fa-undo mr-2"></i> Đặt lại bộ lọc
                    </a>
                @else
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có người dùng nào</h3>
                    <p class="text-gray-500 mb-6">Bạn chưa có người dùng nào trong hệ thống.</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
