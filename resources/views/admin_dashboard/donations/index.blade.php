@extends('admin_dashboard.layouts.app')

@section('page-title', 'Quản lý Donate')

@section('wrapper')
<div class="container-fluid">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">💸 Danh sách Donate (thành công)</h1>
            <p class="text-gray-500 mt-1">Chỉ hiển thị giao dịch thành công của người dùng</p>
        </div>
    </div>

    <!-- Search and Filter -->
    <form method="GET" action="{{ route('admin.donations.index') }}" class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-end">
            <div class="flex-grow w-full">
                <input type="text" name="username" value="{{ request('username') }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                       placeholder="Tìm tên người dùng...">
            </div>
            <div class="flex-grow w-full">
                <input type="text" name="email" value="{{ request('email') }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                       placeholder="Tìm email...">
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <input type="number" name="amount_min" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 w-28" placeholder="Số tiền từ" value="{{ request('amount_min') }}">
                <input type="number" name="amount_max" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 w-28" placeholder="Số tiền đến" value="{{ request('amount_max') }}">
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">
                    Lọc
                </button>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($donations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người dùng</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số tiền</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mô tả</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thời gian</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thanh toán</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($donations as $index => $donate)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donate->user->username ?? 'Khách' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donate->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($donate->amount) }} {{ $donate->currency }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donate->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donate->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-3 py-1 text-xs rounded-full font-bold bg-green-100 text-green-700 border border-green-400">
                                    Đã thanh toán
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4">
                {{ $donations->onEachSide(1)->links('pagination::tailwind') }}
            </div>
        @else
            <div class="p-8 text-center">
                <div class="inline-flex rounded-full bg-yellow-100 p-4 mb-4">
                    <div class="rounded-full bg-yellow-200 p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có giao dịch thành công</h3>
                <p class="text-gray-500 mb-6">Hiện chưa có giao dịch thành công nào.</p>
            </div>
        @endif
    </div>
</div>
@endsection
