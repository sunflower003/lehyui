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
        return view('admin_dashboard.dashboard', [
            'countPost' => Post::count(),
            'countCategories' => Category::count(),
            'countAdmin' => User::where('role', 'admin')->count(),
            'countUser' => User::where('role', 'user')->count(),
            'countComments' => Comment::count(),
            'countView' => 0
        ]);
    }
}
