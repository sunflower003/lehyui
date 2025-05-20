<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
        public function index()
    {
        // 4 bài viết mới nhất
        $recentPosts = Post::latest()->with('user', 'category')->take(4)->get();

        // ID của 4 bài viết đó
        $recentIds = $recentPosts->pluck('id')->toArray();

        // Lấy các bài viết còn lại (trừ recentPosts), và phân trang
        $posts = Post::whereNotIn('id', $recentIds)
                    ->latest()
                    ->with('user', 'category')
                    ->paginate(6);

        return view('home', [
            'user' => $this->getProcessedUser(),
            'recentPosts' => $recentPosts,
            'posts' => $posts
        ]);
    }

}
