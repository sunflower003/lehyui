<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'user' => $this->getProcessedUser(),
            'headerCategories' => Category::orderBy('created_at')->limit(6)->get()
        ]);
    }
}
