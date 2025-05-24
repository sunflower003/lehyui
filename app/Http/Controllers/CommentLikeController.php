<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\CommentLike;

class CommentLikeController extends Controller
{
    // Xử lý LIKE
    public function like($id)
    {
        $user = Auth::user();
        $comment = Comment::findOrFail($id);

        // Kiểm tra đã từng like/dislike chưa
        $like = CommentLike::where('user_id', $user->id)
            ->where('comment_id', $comment->id)
            ->first();

        if ($like && $like->is_like) {
            // Nếu đã like rồi thì bỏ like (unlike)
            $like->delete();
        } else {
            if ($like) {
                // Nếu đã dislike thì chuyển sang like
                $like->update(['is_like' => 1]);
            } else {
                // Nếu chưa từng like/dislike thì tạo mới like
                CommentLike::create([
                    'user_id' => $user->id,
                    'comment_id' => $comment->id,
                    'is_like' => 1,
                ]);
            }
        }
        return back();
    }

    // Xử lý DISLIKE
    public function dislike($id)
    {
        $user = Auth::user();
        $comment = Comment::findOrFail($id);

        // Kiểm tra đã từng like/dislike chưa
        $like = CommentLike::where('user_id', $user->id)
            ->where('comment_id', $comment->id)
            ->first();

        if ($like && !$like->is_like) {
            // Nếu đã dislike rồi thì bỏ dislike
            $like->delete();
        } else {
            if ($like) {
                // Nếu đã like thì chuyển sang dislike
                $like->update(['is_like' => 0]);
            } else {
                // Nếu chưa từng like/dislike thì tạo mới dislike
                CommentLike::create([
                    'user_id' => $user->id,
                    'comment_id' => $comment->id,
                    'is_like' => 0,
                ]);
            }
        }
        return back();
    }
}

