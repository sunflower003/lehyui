<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function byCategory($id)
    {
        $category = Category::findOrFail($id);
        $posts = Post::where('category_id', $id)->latest()->get();

        return view('home', [
            'category' => $category,
            'posts' => $posts,
            'showCategoryPage' => true,
            'user' => $this->getProcessedUser(),
            'headerCategories' => Category::orderBy('created_at')->limit(6)->get()
        ]);
    }
}
