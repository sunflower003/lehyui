@extends('admin_dashboard.layouts.app')

@section('page-title', 'Thêm bài viết mới')

@section('wrapper')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden max-w-5xl mx-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">📝 Thêm bài viết mới</h2>
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

            <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                        required>
                </div>
                
                <div class="mb-4">
                    <label for="sub_title" class="block text-sm font-medium text-gray-700 mb-1">Phụ đề</label>
                    <input type="text" id="sub_title" name="sub_title" value="{{ old('sub_title') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div class="mb-4">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center">
                            <input type="file" id="thumbnail" name="thumbnail" 
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Chuyên mục</label>
                    <select id="category_id" name="category_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                        required>
                        <option value="">-- Chọn chuyên mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-5">
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Nội dung bài viết</label>
                    <div class="border border-gray-300 rounded-md overflow-hidden">
                        <textarea id="body" name="body" class="w-full">{{ old('body') }}</textarea>
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                        Hủy
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors">
                        <i class="fas fa-save mr-2"></i> Đăng bài viết
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
</script>
@endsection
