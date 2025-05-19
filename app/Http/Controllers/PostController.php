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
    $posts = Post::where('category_id', $id)->latest()->with('user')->get();

    return view('pages.categorypost', [
        'category' => $category,
        'posts' => $posts,
        'user' => $this->getProcessedUser(),
        'headerCategories' => Category::orderBy('created_at')->limit(5)->get()
    ]);
}

}