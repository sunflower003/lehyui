<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->paginate(10);
        return view('admin_dashboard.comments.index', compact('comments'));
    }
}
