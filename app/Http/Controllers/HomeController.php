<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Nếu chưa đăng nhập
        if (!$user) {
            $user = (object) [
                'username' => 'Guest',
                'avatar_path' => asset('img/5ee082781b8c41406a2a50a0f32d6aa6.jpg') // ảnh mặc định
            ];
        } else {
            // Nếu đã đăng nhập
            $user->avatar_path = $user->avatar
                ? asset('storage/' . $user->avatar)  // ảnh đã upload
                : asset('img/5ee082781b8c41406a2a50a0f32d6aa6.jpg'); // ảnh mặc định
        }

        // Lấy 6 bài mới nhất cho Recent blog posts
        $recentPosts = Post::with(['user', 'category'])->latest()->take(6)->get();
        // Lấy tất cả bài viết, phân trang 12 bài/trang cho All blog posts
        $posts = Post::with(['user', 'category'])->latest()->paginate(12);
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('home', compact('user', 'posts', 'categories', 'recentPosts'));
    }
}
