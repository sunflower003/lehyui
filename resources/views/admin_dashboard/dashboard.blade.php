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
                    <span class="{{ $growthPost >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    <i class="fas {{ $growthPost >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                    {{ abs($growthPost) }}%
                </span> so với tháng trước
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
                    <span class="{{ $growthCategory >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        <i class="fas {{ $growthCategory >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                        {{ abs($growthCategory) }}%
                    </span> so với tháng trước

                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Tổng tiền đã donate</p>
                        <h3 class="text-2xl font-bold mt-1">{{ number_format($totalDonationSuccess) }} VND</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <span class="{{ $growthDonation >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        <i class="fas {{ $growthDonation >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                        {{ abs($growthDonation) }}%
                    </span> so với tháng trước
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
                    <span class="{{ $growthUser >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        <i class="fas {{ $growthUser >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                        {{ abs($growthUser) }}%
                    </span> so với tháng trước
                </div>
            </div>
        </div>
        
        <!-- Charts -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">📊 Biểu đồ bài viết với bình luận</h3>
                    <div class="flex gap-2">
                        <button class="comment-range px-3 py-1 text-xs bg-gray-100 rounded-full text-gray-600 hover:bg-gray-200" data-days="7">7 ngày</button>
                        <button class="comment-range px-3 py-1 text-xs bg-gray-100 rounded-full text-gray-600 hover:bg-gray-200" data-days="30">30 ngày</button>
                    </div>
                </div>
                <div class="h-[300px]">
                    <canvas id="chart1"></canvas>
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
    const commentLabels = @json($commentLabels);
    const commentData = @json($commentData);
    const postData = @json($postData);
    let commentChart;

    document.addEventListener('DOMContentLoaded', function () {
        // Biểu đồ cột
        const ctx1 = document.getElementById("chart1").getContext('2d');
        commentChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: commentLabels,
                datasets: [
                    {
                        label: 'Bình luận',
                        data: commentData,
                        backgroundColor: '#fbbf24',
                        borderRadius: 6,
                        barThickness: 12,
                    },
                    {
                        label: 'Bài viết',
                        data: postData,
                        backgroundColor: '#6366f1',
                        borderRadius: 6,
                        barThickness: 12,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            padding: 16,
                            boxWidth: 12,
                            usePointStyle: true,
                            pointStyle: 'rectRounded'
                        }
                    }
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
        // sự kiện đổi số ngày
        document.querySelectorAll('.comment-range').forEach(button => {
            button.addEventListener('click', function () {
                const days = this.getAttribute('data-days');
                updateCommentChart(days);
            });
        });
        // Biểu đồ tròn
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
    function updateCommentChart(days) {
        fetch(`/admin/chart/comments?days=${days}`)
            .then(res => res.json())
            .then(data => {
                commentChart.data.labels = data.labels;
                commentChart.data.datasets[0].data = data.comments;
                commentChart.data.datasets[1].data = data.posts;
                commentChart.update();
            });
    }
</script>
@endsection