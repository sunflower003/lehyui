<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Hiển thị danh sách bình luận cho admin
    public function adminIndex(Request $request)
    {
        $query = \App\Models\Comment::query();

        // Tìm kiếm theo nội dung
        if ($request->filled('search')) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        // Lọc theo user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Lọc theo bài viết
        if ($request->filled('post_id')) {
            $query->where('post_id', $request->post_id);
        }

        $sort = $request->get('sort', 'desc');
        $comments = $query->with(['user', 'post'])->orderBy('created_at', $sort)->paginate(10);
        return view('admin_dashboard.comments.index', compact('comments'));
    }

    // Xóa bình luận
    public function adminDestroy(\App\Models\Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Đã xóa bình luận!');
    }

    // Hiển thị danh sách bình luận của một bài viết cho admin
    public function adminList(Request $request)
    {
        $postId = $request->get('post_id');
        // Lấy tất cả bài viết để chọn lọc
        $allPosts = \App\Models\Post::orderBy('created_at', 'desc')->get();
        // Nếu chưa chọn bài viết thì lấy bài đầu tiên
        if (!$postId && $allPosts->count() > 0) {
            $postId = $allPosts->first()->id;
        }
        $post = \App\Models\Post::findOrFail($postId);
        // Lấy bình luận mới nhất trước
        $comments = $post->comments()->with('user')->get();
        return view('admin_dashboard.comments.list', compact('comments', 'post', 'allPosts'));
    }

 
 
}
