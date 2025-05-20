<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Comment;

use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Added comment.');
    }


    public function destroy(Comment $comment)
    {
        // Chỉ cho phép xóa nếu là chủ sở hữu
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'You do not have permission to delete this comment.');
        }

        $comment->delete();

        return back()->with('success', 'Deleted comment.');
    }

     public function index()
    {
        $comments = Comment::latest()->paginate(10);
        return view('admin_dashboard.comments.index', compact('comments'));
    }
}
