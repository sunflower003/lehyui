@extends('admin_dashboard.layouts.app')

@section('title', 'Quản lý bình luận')

@section('wrapper')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="font-bold text-2xl mb-1 flex items-center">
                <i class="fas fa-comments mr-2 text-indigo-500"></i> Danh sách bình luận
            </h2>
            <p class="text-gray-500 mb-3">Quản lý tất cả bình luận của người dùng</p>
        </div>
        <div class="col-12 mb-3">
            <form method="GET" action="" class="flex flex-wrap gap-2 items-center justify-end">
                <input type="text" name="search" class="form-control rounded shadow-sm" style="max-width:150px" placeholder="Tìm nội dung..." value="{{ request('search') }}">
                <input type="number" name="user_id" class="form-control rounded shadow-sm" style="max-width:110px" placeholder="User ID" value="{{ request('user_id') }}">
                <input type="number" name="post_id" class="form-control rounded shadow-sm" style="max-width:110px" placeholder="Post ID" value="{{ request('post_id') }}">
                <select name="sort" class="form-control rounded shadow-sm" style="max-width:120px">
                    <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Cũ nhất</option>
                </select>
                <button type="submit" class="btn btn-primary rounded shadow">Lọc</button>
            </form>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl shadow-lg p-0 overflow-hidden">
        <table class="table mb-0 align-middle" style="border-collapse:separate; border-spacing:0;">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-center" style="width:40px;">#</th>
                    <th class="text-left">Người bình luận</th>
                    <th class="text-left">Bài viết</th>
                    <th class="text-left">Nội dung</th>
                    <th class="text-center" style="width:120px;">Thời gian</th>
                    <th class="text-center" style="width:70px;">Hành động</th>
                </tr>
            </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr class="align-middle hover:bg-gray-50 transition">
                                <td class="text-center text-muted">{{ $comment->id }}</td>
                                <td class="font-semibold text-gray-800">{{ $comment->user->username ?? 'Ẩn danh' }}</td>
                                <td>
                                    @if($comment->post)
                                        <a href="{{ route('posts.show', $comment->post->id) }}" target="_blank" class="text-indigo-600 hover:underline">{{ $comment->post->title }}</a>
                                    @else
                                        <span class="text-muted">[Đã xóa]</span>
                                    @endif
                                </td>
                                <td class="text-gray-700">{{ $comment->content }}</td>
                                <td class="text-center text-gray-500" style="white-space:nowrap">{{ $comment->created_at->diffForHumans() }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link p-0 text-danger" style="border:none;background:transparent;">
                                            <i class="fas fa-trash fa-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Không có bình luận nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
        </table>
        <div class="d-flex justify-content-center py-4">
            {{ $comments->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
