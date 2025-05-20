<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public static function getHeaderCategories()
    {
        return Category::orderBy('created_at', 'asc')->limit(5)->get();
    }
    public function showAllCategories()
    {
        $categories = Category::withCount('posts')
                      ->orderBy('created_at', 'asc') // sắp xếp theo thứ tự cũ -> mới
                      ->get();

        $user = auth()->check() ? auth()->user() : null;

        return view('pages.allcategories', [
            'categories' => $categories,
            'user' => $user,
        ]);
    }

}
