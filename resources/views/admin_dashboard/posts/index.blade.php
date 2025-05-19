@extends('admin_dashboard.layouts.app')

@section('wrapper')
<div class="container mt-4" style="max-width: 1000px;">
    <h2 class="mb-4">📄 Danh sách bài viết</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('admin.posts.create') }}" class="btn btn-success mb-3">+ Thêm bài viết</a>

    @if($posts->count() > 0)
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Tiêu đề</th>
                    <th>Phụ đề</th>
                    <th>Ảnh</th>
                    <th>Chuyên mục</th>
                    <th>Người viết</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $index => $post)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->sub_title ?? '—' }}</td>
                    <td class="text-center">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" width="90">
                        @else
                            <em>Không có</em>
                        @endif
                    </td>
                    <td>{{ $post->category->name ?? 'Không rõ' }}</td>
                    <td>{{ $post->user->username ?? 'Không rõ' }}</td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning btn-sm">✏️ Sửa</a>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Xoá bài viết này?')" class="btn btn-danger btn-sm">🗑️ Xoá</button>
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
