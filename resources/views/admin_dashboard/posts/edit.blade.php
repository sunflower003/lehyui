@extends('admin_dashboard.layouts.app')

@section('wrapper')
<div class="container mt-4" style="max-width: 800px;">
    <h2 class="mb-4">✏️ Chỉnh sửa bài viết</h2>

    <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mb-3">
            <label for="sub_title" class="form-label">Phụ đề</label>
            <input type="text" id="sub_title" name="sub_title" class="form-control" value="{{ old('sub_title', $post->sub_title) }}">
        </div>

        <div class="mb-3">
            <label for="thumbnail" class="form-label">Ảnh đại diện</label>
            <input type="file" id="thumbnail" name="thumbnail" class="form-control">
            @if ($post->thumbnail)
                <div class="mt-2">
                    <strong>Ảnh hiện tại:</strong><br>
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail" width="150">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Chuyên mục</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <option value="">-- Chọn chuyên mục --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Nội dung bài viết</label>
            <textarea id="body" name="body" class="form-control">{!! old('body', $post->body) !!}</textarea>
        </div>


        <button type="submit" class="btn btn-primary">💾 Cập nhật bài viết</button>
    </form>
</div>
@endsection

@section('style')
<!-- Bootstrap 5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('script')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/5nk94xe9fcwk22fkp6gou9ymszwidnujnr2mu3n3xe2biap3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#body',
        height: 500,
        menubar: true,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | preview code fullscreen',
        content_style: 'body { font-family:Roboto,sans-serif; font-size:16px }'
    });
</script>
@endsection
