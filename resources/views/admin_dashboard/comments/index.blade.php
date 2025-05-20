@extends('admin_dashboard.layouts.app')

@section('page-title', 'Danh sách bình luận')

@section('wrapper')
<div class="container-fluid">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">💬 Danh sách bình luận</h1>
            <p class="text-gray-500 mt-1">Quản lý tất cả bình luận của người dùng</p>
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

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($comments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người bình luận</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bài viết</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nội dung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thời gian</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($comments as $index => $comment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $comment->user->username ?? 'Ẩn danh' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-700">
                                {{ $comment->post->title ?? 'Không rõ' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 max-w-xs truncate">
                                {{ Str::limit($comment->content, 80) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $comment->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Hiển thị <span class="font-medium">1</span> đến <span class="font-medium">10</span> của <span class="font-medium">{{ $comments->total() }}</span> bình luận
                        </p>
                    </div>
                    <div>
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="p-8 text-center">
                <div class="inline-flex rounded-full bg-yellow-100 p-4 mb-4">
                    <div class="rounded-full bg-yellow-200 p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có bình luận nào</h3>
                <p class="text-gray-500 mb-6">Hệ thống chưa ghi nhận bình luận từ người dùng.</p>
            </div>
        @endif
    </div>
</div>
@endsection
