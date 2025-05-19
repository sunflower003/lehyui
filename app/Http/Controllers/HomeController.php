<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        // get 4 most recent posts for recent_container
        $recentPosts = Post::latest()->with('user', 'category')->take(4)->get();
        
        return view('home', [
            'user' => $this->getProcessedUser(),
            'headerCategories' => Category::orderBy('created_at')->limit(6)->get(),
            'recentPosts' => $recentPosts
        ]);
    }
}
