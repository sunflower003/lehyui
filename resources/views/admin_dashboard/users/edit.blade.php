@extends('admin_dashboard.layouts.app')

@section('page-title', 'Chỉnh sửa người dùng')

@section('wrapper')
<div class="flex justify-center items-center min-h-[60vh]">
    <div class="bg-white rounded-xl shadow-lg px-8 py-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Sửa thông tin người dùng</h2>
        @if ($errors->any())
            <div class="mb-4">
                @foreach ($errors->all() as $error)
                    <div class="text-red-600 text-sm mb-1">{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="block text-gray-700 font-medium mb-2">Username</label>
                <input type="text" name="username"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    value="{{ $user->username }}" required>
            </div>
            <div class="mb-3">
                <label class="block text-gray-700 font-medium mb-2">Giới tính</label>
                <select name="sex"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    required>
                    <option value="male" {{ $user->sex === 'male' ? 'selected' : '' }}>Nam</option>
                    <option value="female" {{ $user->sex === 'female' ? 'selected' : '' }}>Nữ</option>
                </select>
            </div>
            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Quyền</label>
                <select name="role"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    required>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="flex justify-center gap-3">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <i class="fas fa-save mr-2"></i> Cập nhật
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg shadow transition-all duration-150">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
