@extends('admin_dashboard.layouts.app')

@section('title', 'Quản lý bình luận theo bài viết')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Bình luận của bài viết: <span class="text-primary">{{ $post->title }}</span></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại danh sách bài viết</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <form method="GET" action="">
                <div class="form-group row">
                    <label for="post_id" class="col-sm-2 col-form-label">Chọn bài viết:</label>
                    <div class="col-sm-6">
                        <select name="post_id" id="post_id" class="form-control" onchange="this.form.submit()">
                            @foreach($allPosts as $item)
                                <option value="{{ $item->id }}" {{ $post->id == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nội dung</th>
                            <th>Người bình luận</th>
                            <th>Ngày bình luận</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $comment->content }}</td>
                                <td>{{ $comment->user->username ?? 'Ẩn danh' }}</td>
                                <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($comment->status == 'approved')
                                        <span class="badge badge-success">Đã duyệt</span>
                                    @else
                                        <span class="badge badge-warning">Chờ duyệt</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có bình luận nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
