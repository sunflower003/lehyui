@extends('admin_dashboard.layouts.app')

@section('page-title', 'Thêm bài viết mới')

@section('wrapper')
<div class="container-fluid max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">📝 Thêm bài viết mới</h1>
            <p class="text-gray-500 mt-1">Tạo nội dung mới cho trang web của bạn</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-md transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
        <div class="flex">
            <div class="py-1"><i class="fas fa-exclamation-circle text-red-500 mr-3"></i></div>
            <div>
                <p class="font-bold">Đã xảy ra lỗi</p>
                <ul class="mt-1 ml-4 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            required>
                    </div>
                    
                    <div>
                        <label for="sub_title" class="block text-sm font-medium text-gray-700 mb-2">Phụ đề</label>
                        <input type="text" id="sub_title" name="sub_title" value="{{ old('sub_title') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Chuyên mục <span class="text-red-500">*</span></label>
                        <select id="category_id" name="category_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            required>
                            <option value="">-- Chọn chuyên mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện</label>
                        <div class="flex items-center">
                            <label class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-md shadow-sm border border-gray-300 border-dashed cursor-pointer hover:bg-gray-50">
                                <span class="mx-auto flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100">
                                    <i class="fas fa-cloud-upload-alt text-indigo-600"></i>
                                </span>
                                <span class="mt-2 text-base leading-normal text-gray-600">Chọn ảnh</span>
                                <span class="text-xs text-gray-500">PNG, JPG hoặc GIF</span>
                                <input type="file" id="thumbnail" name="thumbnail" class="hidden">
                            </label>
                        </div>
                        <div id="thumbnail-preview" class="mt-2 hidden">
                            <div class="flex items-center">
                                <img id="preview-image" src="#" alt="Preview" class="h-16 w-24 object-cover rounded">
                                <button type="button" id="remove-thumbnail" class="ml-2 text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Nội dung bài viết <span class="text-red-500">*</span></label>
                    <textarea id="body" name="body" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('body') }}</textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="window.history.back()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-md transition-colors">
                        Hủy
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                        <i class="fas fa-save mr-2"></i> Đăng bài viết
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/5nk94xe9fcwk22fkp6gou9ymszwidnujnr2mu3n3xe2biap3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Initialize TinyMCE
    tinymce.init({
        selector: '#body',
        height: 500,
        menubar: true,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | preview code fullscreen',
        content_style: 'body { font-family:Roboto,sans-serif; font-size:16px }',
        skin: 'oxide',
        // Use a modern theme
        content_css: 'default',
        // Add custom styling
        setup: function(editor) {
            editor.on('init', function() {
                editor.getContainer().style.transition = "border-color 0.15s ease-in-out";
                editor.getContainer().style.border = "1px solid #d1d5db";
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

    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnailInput = document.getElementById('thumbnail');
        const previewContainer = document.getElementById('thumbnail-preview');
        const previewImage = document.getElementById('preview-image');
        const removeButton = document.getElementById('remove-thumbnail');

        thumbnailInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeButton.addEventListener('click', function() {
            thumbnailInput.value = '';
            previewContainer.classList.add('hidden');
        });
    });
</script>
@endsection
