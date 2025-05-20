<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public static function getHeaderCategories()
    {
        return Category::orderBy('created_at', 'asc')->limit(5)->get();
    }
}
