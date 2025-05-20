@extends('admin_dashboard.layouts.app')

@section('page-title', 'Danh sách bài viết')

@section('wrapper')
<div class="container-fluid">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">📄 Danh sách bài viết</h1>
            <p class="text-gray-500 mt-1">Quản lý tất cả bài viết của bạn</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                <i class="fas fa-plus mr-2"></i> Thêm bài viết
            </a>
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
    <form method="GET" action="{{ route('admin.posts.index') }}" class="bg-white p-4 rounded-lg shadow mb-6">
    <div class="flex flex-col md:flex-row gap-4 items-start md:items-end">
        {{-- Tìm kiếm --}}
        <div class="flex-grow w-full">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5" 
                    placeholder="Tìm kiếm bài viết...">
            </div>
        </div>

        {{-- Bộ lọc --}}
        <div class="flex gap-3 w-full md:w-auto">
            {{-- Lọc theo danh mục --}}
            <select name="category_id" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                <option value="">Tất cả danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            {{-- Sắp xếp --}}
            <select name="sort" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Tiêu đề (A-Z)</option>
            </select>

            {{-- Nút lọc --}}
            <button type="submit" 
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">
                Lọc
            </button>
        </div>
    </div>
</form>

    
    <!-- Posts Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($posts->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ảnh</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chuyên mục</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người viết</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($posts as $index => $post)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                                @if($post->sub_title)
                                    <div class="text-sm text-gray-500">{{ $post->sub_title }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($post->thumbnail)
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="h-16 w-24 object-cover rounded" alt="{{ $post->title }}">
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800">Không có ảnh</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-800">
                                    {{ $post->category->name ?? 'Không rõ' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $post->user->username ?? 'Không rõ' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $post->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 p-2 rounded-md transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Xoá bài viết này?')" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-2 rounded-md transition-colors">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a href="#" class="text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 p-2 rounded-md transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $posts->appends(request()->query())->links() }}
            </div>

            
            <!-- Pagination 
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Hiển thị <span class="font-medium">1</span> đến <span class="font-medium">10</span> của <span class="font-medium">{{ $posts->count() }}</span> kết quả
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#" aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                1
                            </a>
                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                2
                            </a>
                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                3
                            </a>
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                ...
                            </span>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div> -->
        @else
            <div class="p-8 text-center">
                <div class="inline-flex rounded-full bg-yellow-100 p-4 mb-4">
                    <div class="rounded-full bg-yellow-200 p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                </div>
                @if(request()->hasAny(['search', 'category_id', 'sort']))
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Không tìm thấy kết quả</h3>
                    <p class="text-gray-500 mb-6">Không có bài viết nào khớp với tiêu chí tìm kiếm hoặc bộ lọc của bạn.</p>
                    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-md transition-colors">
                        <i class="fas fa-undo mr-2"></i> Đặt lại bộ lọc
                    </a>
                @else
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có bài viết nào</h3>
                    <p class="text-gray-500 mb-6">Bạn chưa có bài viết nào. Hãy tạo bài viết đầu tiên của bạn.</p>
                    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                        <i class="fas fa-plus mr-2"></i> Thêm bài viết
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
