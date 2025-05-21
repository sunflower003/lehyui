<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardControllers extends Controller
{
    public function index()
{
    $now = Carbon::now();
    $startOfThisMonth = $now->copy()->startOfMonth();
    $endOfThisMonth = $now->copy()->endOfMonth();

    $lastMonth = $now->copy()->subMonth();
    $startOfLastMonth = $lastMonth->copy()->startOfMonth();
    $endOfLastMonth = $lastMonth->copy()->endOfMonth();

    //Tổng hiện tại
    $countPost = Post::count();
    $countCategories = Category::count();
    $countAdmin = User::where('role', 'admin')->count();
    $countUser = User::where('role', 'user')->count();
    
    // Tổng tháng này
    $postThisMonth = Post::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();
    $userThisMonth = User::where('role', 'user')->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();
    $categoryThisMonth = Category::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();

    // Tổng tháng trước
    $postLastMonth = Post::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
    $userLastMonth = User::where('role', 'user')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
    $categoryLastMonth = Category::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

    // Tính phần trăm tăng giảm với điều kiện đầy đủ
    $growthPost = $postLastMonth > 0
        ? round((($postThisMonth - $postLastMonth) / $postLastMonth) * 100)
        : ($postThisMonth > 0 ? 100 : 0);

    $growthUser = $userLastMonth > 0
        ? round((($userThisMonth - $userLastMonth) / $userLastMonth) * 100)
        : ($userThisMonth > 0 ? 100 : 0);

    $growthCategory = $categoryLastMonth > 0
        ? round((($categoryThisMonth - $categoryLastMonth) / $categoryLastMonth) * 100)
        : ($categoryThisMonth > 0 ? 100 : 0);

    // Bài viết gần đây
    $recentPosts = Post::with('category', 'user')
                        ->latest()
                        ->take(5)
                        ->get();
    // Dữ liệu mặc định cho biểu đồ 7 ngày
        $days = 7;
        $fromDate = Carbon::now()->subDays($days - 1)->startOfDay();

        $commentStats = $this->getStatsByDate('comments', $fromDate);
        $postStats = $this->getStatsByDate('posts', $fromDate);
        $userStats = $this->getStatsByDate('users', $fromDate);

        $labels = [];
        $commentData = [];
        $postData = [];
        $userData = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $label = Carbon::now()->subDays($i)->format('d/m');

            $labels[] = $label;
            $commentData[] = optional($commentStats->firstWhere('date', $date))->total ?? 0;
            $postData[] = optional($postStats->firstWhere('date', $date))->total ?? 0;
            $userData[] = optional($userStats->firstWhere('date', $date))->total ?? 0;
        }
    // Thống kê bài viết theo danh mục
    $categoryStats = Category::withCount('posts')->get();
    $chartLabels = $categoryStats->pluck('name');
    $chartData = $categoryStats->pluck('posts_count');

    return view('admin_dashboard.dashboard', [
        'countPost' => $countPost,
        'countCategories' => $countCategories,
        'countAdmin' => $countAdmin,
        'countUser' => $countUser,
        'recentPosts' => $recentPosts,
        'chartLabels' => $chartLabels,
        'chartData' => $chartData,
        'commentLabels' => $labels,
        'commentData' => $commentData,
        'postData' => $postData,
        'growthPost' => $growthPost,
        'growthUser' => $growthUser,
        'growthCategory' => $growthCategory,
        'postThisMonth' => $postThisMonth,
        'userThisMonth' => $userThisMonth,
        'categoryThisMonth' => $categoryThisMonth,
        ]);
}

    public function getCommentChartData(\Illuminate\Http\Request $request)
{
        $days = intval($request->query('days', 7));
        $fromDate = Carbon::now()->subDays($days - 1)->startOfDay();

        $commentStats = $this->getStatsByDate('comments', $fromDate);
        $postStats = $this->getStatsByDate('posts', $fromDate);

        $labels = [];
        $commentData = [];
        $postData = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $labels[] = Carbon::now()->subDays($i)->format('d/m');

            $commentData[] = optional($commentStats->firstWhere('date', $date))->total ?? 0;
            $postData[] = optional($postStats->firstWhere('date', $date))->total ?? 0;
            
        }

        return response()->json([
            'labels' => $labels,
            'comments' => $commentData,
            'posts' => $postData,
            
        ]);
    }

    private function getStatsByDate($table, $fromDate)
    {
        return DB::table($table)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $fromDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }


}
