@extends('layouts.app')

@section('style')
    {{-- Tích hợp TinyMCE từ CDN --}}
    <script src="https://cdn.tiny.cloud/1/f4y6xy9qze0cpo0ylb07aus0azkzcec4yttxrj4nd98aikl7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#body',
            height: 400,
            menubar: false,
            plugins: 'lists link image code table',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code',
        });
    </script>
@endsection

@section('content')
    <h2>Thêm bài viết mới</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Lỗi!</strong> Vui lòng kiểm tra lại dữ liệu.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title">Tiêu đề</label>
            <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="sub_title">Phụ đề</label>
            <input type="text" class="form-control" name="sub_title" value="{{ old('sub_title') }}">
        </div>
        <div class="mb-3">
            <label for="thumbnail">Ảnh đại diện</label>
            <input type="file" class="form-control" name="thumbnail">
        </div>
        <div class="mb-3">
            <label for="body">Nội dung</label>
            <textarea name="body" id="body" class="form-control">{{ old('body') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="user_id">Người đăng</label>
            <input type="number" name="user_id" class="form-control" value="1" required> {{-- Tạm cứng user_id --}}
        </div>
        <div class="mb-3">
            <label for="category_id">Chuyên mục</label>
            <input type="number" name="category_id" class="form-control" value="1" required> {{-- Tạm cứng category_id --}}
        </div>
        <button type="submit" class="btn btn-primary">Thêm bài viết</button>
    </form>
@endsection
