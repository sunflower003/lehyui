@extends("admin_dashboard.layouts.app")

@section('page-title', 'Dashboard')

@section("wrapper")
<div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-screen-xl">
    <div class="w-full max-w-6xl mx-auto">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Tổng bài viết</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $countPost }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-newspaper text-indigo-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <span class="text-green-500"><i class="fas fa-arrow-up"></i> 12%</span> so với tháng trước
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Tổng danh mục</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $countCategories }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-folder text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <span class="text-green-500"><i class="fas fa-arrow-up"></i> 5%</span> so với tháng trước
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Tổng người quản trị</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $countAdmin }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <span class="text-gray-500"><i class="fas fa-minus"></i> 0%</span> không thay đổi
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Tổng khách hàng</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $countUser }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <span class="text-green-500"><i class="fas fa-arrow-up"></i> 18%</span> so với tháng trước
                </div>
            </div>
        </div>
        
        <!-- Charts -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">📊 Biểu đồ lượt xem & bình luận</h3>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-xs bg-gray-100 rounded-full text-gray-600 hover:bg-gray-200">7 ngày</button>
                        <button class="px-3 py-1 text-xs bg-gray-100 rounded-full text-gray-600 hover:bg-gray-200">30 ngày</button>
                    </div>
                </div>
                <div class="h-[300px]">
                    <canvas id="chart1"></canvas>
                </div>
                <div class="flex gap-4 mt-4 justify-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full bg-indigo-500 inline-block mr-2"></span>
                        <span class="text-sm text-gray-600">Lượt xem</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full bg-amber-400 inline-block mr-2"></span>
                        <span class="text-sm text-gray-600">Bình luận</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">📈 Thống kê bài viết theo danh mục</h3>
                    <div>
                        <button class="px-3 py-1 text-xs bg-gray-100 rounded-full text-gray-600 hover:bg-gray-200">
                            <i class="fas fa-download mr-1"></i> Xuất
                        </button>
                    </div>
                </div>
                <div class="h-[300px]">
                    <canvas id="chart2"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Recent Posts -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold">📝 Bài viết gần đây</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                    Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="overflow-x-auto max-w-full">
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người viết</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentPosts as $post)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $post->category->name ?? 'Không rõ' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $post->user->username ?? 'Không rõ' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $post->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Đã xuất bản
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const categoryLabels = @json($chartLabels);
    const categoryData = @json($chartData);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Chart 1 - Bar Chart
        const ctx1 = document.getElementById("chart1").getContext('2d');
        const chart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['16/03', '17/03', '18/03', '19/03', '20/03', '21/03', '22/03'],
                datasets: [
                    {
                        label: 'Lượt xem',
                        data: [10, 13, 9, 16, 10, 12, 15],
                        backgroundColor: '#6366f1',
                        borderRadius: 6,
                        barThickness: 12,
                    },
                    {
                        label: 'Bình luận',
                        data: [8, 14, 19, 12, 7, 18, 8],
                        backgroundColor: '#fbbf24',
                        borderRadius: 6,
                        barThickness: 12,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6c757d' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#6c757d' }
                    }
                }
            }
        });
        
        // Chart 2 - Doughnut Chart
        const ctx2 = document.getElementById("chart2").getContext('2d');
        const chart2 = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: [
                        '#6366f1', '#3b82f6', '#10b981', '#f59e0b', '#6b7280'
                    ],
                    borderWidth: 0,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            boxWidth: 10,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
