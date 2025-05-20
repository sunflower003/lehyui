@extends('admin_dashboard.layouts.app')

@section('page-title', 'Danh sách bình luận')

@section('wrapper')
<div class="w-full max-w-4xl mx-auto mt-10 px-2">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold flex items-center">
                <i class="fas fa-comments text-indigo-500 mr-2"></i> Danh sách bình luận
            </h1>
            <p class="text-gray-500 mt-1">Quản lý tất cả bình luận của người dùng</p>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <div class="flex">
                <div class="py-1"><i class="fas fa-check-circle text-green-500 mr-3"></i></div>
                <div><p>{{ session('success') }}</p></div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5" aria-label="Close">
                    <i class="fas fa-times text-green-500"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.comments.index') }}" class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-end">

            {{-- Search nội dung --}}
            <div class="flex-grow w-full">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5"
                        placeholder="Tìm kiếm bình luận..."
                    >
                </div>
            </div>

            {{-- Filter người bình luận --}}
            <select
                name="user_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 w-full md:w-auto"
            >
                <option value="">Tất cả người bình luận</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                        {{ $u->username }}
                    </option>
                @endforeach
            </select>

            {{-- Sort theo thời gian --}}
            <select
                name="sort"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 w-full md:w-auto"
            >
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
            </select>

            <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg"
            >
                Lọc
            </button>
        </div>
    </form>

    {{-- Table danh sách bình luận --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        @if($comments->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Người bình luận</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bài viết</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nội dung</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thời gian</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($comments as $idx => $comment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $comments->firstItem() + $idx }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $comment->user->username ?? 'Ẩn danh' }}
                        </td>
                        <td class="px-4 py-4 text-sm text-indigo-700">
                            {{ $comment->post->title ?? 'Không rõ' }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-800 max-w-xs truncate">
                            {{ Str::limit($comment->content, 100) }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            {{ $comment->created_at->diffForHumans() }}
                        </td>
                        <td class="px-4 py-4 text-sm font-medium">
                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Xoá bình luận này?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-2 rounded-md transition-colors"
                                    title="Xoá"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div>
                    <p class="text-sm text-gray-700">
                        Hiển thị <span class="font-medium">{{ $comments->firstItem() }}</span> đến
                        <span class="font-medium">{{ $comments->lastItem() }}</span> của
                        <span class="font-medium">{{ $comments->total() }}</span> bình luận
                    </p>
                </div>
                <div>
                    {{ $comments->appends(request()->all())->links() }}
                </div>
            </div>
        @else
            {{-- Empty state --}}
            <div class="p-8 text-center">
                <div class="inline-flex rounded-full bg-yellow-100 p-4 mb-4">
                    <div class="rounded-full bg-yellow-200 p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                </div>
                @if(request()->hasAny(['search','user_id','sort']))
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Không tìm thấy kết quả</h3>
                    <p class="text-gray-500 mb-6">Không có bình luận nào khớp với tiêu chí của bạn.</p>
                    <a href="{{ route('admin.comments.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-md transition-colors">
                        <i class="fas fa-undo mr-2"></i> Đặt lại bộ lọc
                    </a>
                @else
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có bình luận nào</h3>
                    <p class="text-gray-500 mb-6">Hệ thống chưa ghi nhận bình luận từ người dùng.</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
