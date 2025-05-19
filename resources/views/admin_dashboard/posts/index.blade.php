@extends('admin_dashboard.layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 900px;">
    <h2 class="mb-4">📄 Danh sách bài viết</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('admin.posts.create') }}" class="btn btn-success mb-3">+ Thêm bài viết</a>

    @if($posts->count() > 0)
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Tiêu đề</th>
                    <th>Ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" width="100">
                        @else
                            <em>Không có ảnh</em>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning btn-sm">✏️ Sửa</a>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Bạn có chắc muốn xoá?')" class="btn btn-danger btn-sm">🗑️ Xoá</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Chưa có bài viết nào.</div>
    @endif
</div>
@endsection
