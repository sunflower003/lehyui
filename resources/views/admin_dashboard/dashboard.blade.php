@extends("admin_dashboard.layouts.app")

@section("style")
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 20px;
    }
    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card .label {
        color: #6c757d;
        font-size: 14px;
    }
    .card .value {
        font-size: 28px;
        font-weight: bold;
        margin-top: 10px;
    }
    .chart-section {
        display: flex;
        flex-direction: column;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .chart-section canvas {
        width: 100% !important;
        height: 300px !important;
    }
    .chart-legend {
        display: flex;
        gap: 15px;
        font-size: 14px;
        margin-top: 15px;
    }
    .legend-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 6px;
    }
</style>
@endsection

@section("wrapper")
<div>
    <div class="dashboard">
        <div class="card">
            <div class="label">Tổng bài viết</div>
            <div class="value">{{ $countPost }}</div>
        </div>
        <div class="card">
            <div class="label">Tổng danh mục</div>
            <div class="value">{{ $countCategories }}</div>
        </div>
        <div class="card">
            <div class="label">Tổng người quản trị</div>
            <div class="value">{{ $countAdmin }}</div>
        </div>
        <div class="card">
            <div class="label">Tổng khách hàng</div>
            <div class="value">{{ $countUser }}</div>
        </div>
    </div>

    <div class="chart-section">
        <h3>📊 Biểu đồ lượt xem & bình luận</h3>
        <canvas id="chart1"></canvas>
        <div class="chart-legend">
            <span><span class="legend-dot" style="background:#6078ea;"></span> Lượt xem</span>
            <span><span class="legend-dot" style="background:#ffc107;"></span> Bình luận</span>
        </div>
    </div>
</div>
@endsection

@section("script")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById("chart1").getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['16/03', '17/03', '18/03', '19/03', '20/03', '21/03', '22/03'],
                datasets: [
                    {
                        label: 'Lượt xem',
                        data: [10, 13, 9, 16, 10, 12, 15],
                        backgroundColor: '#6078ea'
                    },
                    {
                        label: 'Bình luận',
                        data: [8, 14, 19, 12, 7, 18, 8],
                        backgroundColor: '#ffc107'
                    }
                ]
            },
            options: {
                responsive: true,
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
    });
</script>
@endsection