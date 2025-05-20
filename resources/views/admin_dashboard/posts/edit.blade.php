@extends('admin_dashboard.layouts.app')

@section('page-title', 'Chỉnh sửa bài viết')

@section('wrapper')
<div class="container-fluid py-4 px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden max-w-5xl mx-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <i class="fas fa-edit text-indigo-500 mr-2"></i>
                    <h2 class="text-xl font-bold text-gray-800">Chỉnh sửa bài viết</h2>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left text-sm"></i>
                    <span>Quay lại</span>
                </a>
            </div>

            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Đã xảy ra lỗi</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                            required>
                    </div>
                    
                    <div>
                        <label for="sub_title" class="block text-sm font-medium text-gray-700 mb-1">Phụ đề</label>
                        <input type="text" id="sub_title" name="sub_title" value="{{ old('sub_title', $post->sub_title) }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Chọn tệp</span>
                                        <input id="thumbnail" name="thumbnail" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">hoặc kéo thả vào đây</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 2MB</p>
                            </div>
                        </div>
                        
                        @if ($post->thumbnail)
                        <div class="mt-3 p-3 bg-gray-50 rounded-md border border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">Ảnh hiện tại:</p>
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail" class="h-32 w-auto object-cover rounded-md border border-gray-200">
                        </div>
                        @endif
                    </div>
                    
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Chuyên mục</label>
                        <select id="category_id" name="category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                            required>
                            <option value="">-- Chọn chuyên mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Nội dung bài viết</label>
                        <div class="mt-1 border border-gray-300 rounded-md overflow-hidden">
                            <textarea id="body" name="body" class="w-full">{!! old('body', $post->body) !!}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="pt-5 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                        Hủy
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors">
                        <i class="fas fa-save mr-2"></i> Cập nhật bài viết
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Custom styling for TinyMCE */
    .tox-tinymce {
        border-radius: 0.375rem !important;
        border-color: #d1d5db !important;
    }
    
    .tox .tox-toolbar__group {
        border-color: #e5e7eb !important;
    }
    
    .tox .tox-tbtn {
        border-radius: 0.25rem !important;
    }
    
    .tox .tox-tbtn:hover {
        background-color: #f3f4f6 !important;
    }
    
    .tox .tox-tbtn--enabled, 
    .tox .tox-tbtn--enabled:hover {
        background-color: #e5e7eb !important;
    }
    
    /* File input styling */
    input[type="file"]::file-selector-button {
        border: 0;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        background-color: #eef2ff;
        color: #4f46e5;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    input[type="file"]::file-selector-button:hover {
        background-color: #e0e7ff;
    }
</style>
@endsection

@section('script')
<script src="https://cdn.tiny.cloud/1/5nk94xe9fcwk22fkp6gou9ymszwidnujnr2mu3n3xe2biap3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#body',
        height: 500,
        menubar: true,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | preview code fullscreen',
        content_style: 'body { font-family:Roboto,sans-serif; font-size:16px }',
        // Improve the UI
        skin: 'oxide',
        // Add custom styling
        setup: function(editor) {
            editor.on('init', function() {
                editor.getContainer().style.transition = "border-color 0.15s ease-in-out";
                editor.getContainer().style.borderRadius = "0.375rem";
            });
            editor.on('focus', function() {
                editor.getContainer().style.borderColor = "#6366f1";
                editor.getContainer().style.boxShadow = "0 0 0 3px rgba(99, 102, 241, 0.1)";
            });
            editor.on('blur', function() {
                editor.getContainer().style.borderColor = "#d1d5db";
                editor.getContainer().style.boxShadow = "none";
            });
        }
    });
    
    document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('thumbnail');

    // Tạo vùng hiển thị preview ảnh mới
    const previewWrapper = document.createElement('div');
    previewWrapper.classList.add('mt-4', 'text-center');
    const previewLabel = document.createElement('p');
    previewLabel.classList.add('text-sm', 'text-gray-500', 'mb-2');
    previewLabel.innerText = 'Ảnh mới:';
    const previewImage = document.createElement('img');
    previewImage.classList.add('mx-auto', 'h-32', 'rounded-md', 'border', 'border-gray-300', 'shadow-sm');

    previewWrapper.appendChild(previewLabel);
    previewWrapper.appendChild(previewImage);
    previewWrapper.style.display = 'none';

    // Gắn vùng preview vào sau khối input
    input.closest('.space-y-1').appendChild(previewWrapper);

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewWrapper.style.display = 'block';

                // Ẩn ảnh cũ nếu có
                const oldThumb = document.getElementById('old-thumbnail');
                if (oldThumb) {
                    oldThumb.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    });
});

</script>
@endsection
