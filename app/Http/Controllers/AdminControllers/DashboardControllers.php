<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;

class DashboardControllers extends Controller
{
    public function index()
{
    $countPost = Post::count();
    $countCategories = Category::count();
    $countAdmin = User::where('role', 'admin')->count();
    $countUser = User::where('role', 'user')->count();
    $countComments = Comment::count();
    $countView = 0; // Nếu có bảng views thì thay bằng View::count()

    // Bài viết gần đây
    $recentPosts = Post::with('category', 'user')
                        ->latest()
                        ->take(5)
                        ->get();

    // Thống kê bài viết theo danh mục
    $categoryStats = Category::withCount('posts')->get();
    $chartLabels = $categoryStats->pluck('name');
    $chartData = $categoryStats->pluck('posts_count');

    return view('admin_dashboard.dashboard', [
        'countPost' => $countPost,
        'countCategories' => $countCategories,
        'countAdmin' => $countAdmin,
        'countUser' => $countUser,
        'countComments' => $countComments,
        'countView' => $countView,
        'recentPosts' => $recentPosts,
        'chartLabels' => $chartLabels,
        'chartData' => $chartData,
    ]);
}

}
