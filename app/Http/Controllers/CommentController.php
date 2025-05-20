<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Lưu bình luận mới (frontend).
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_id'  => Auth::id(),
        ]);

        return back()->with('success', 'Đã thêm bình luận.');
    }

    /**
     * Hiển thị trang quản lý bình luận (admin).
     * Hỗ trợ search, lọc, sort.
     */
    public function index(Request $request)
    {
        // Chuẩn bị query
        $query = Comment::with(['post', 'user']);

        // Search nội dung
        if ($request->filled('search')) {
            $query->where('content', 'like', '%'.$request->search.'%');
        }

        // Lọc theo người bình luận
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Sắp xếp theo thời gian
        $direction = $request->sort === 'oldest' ? 'asc' : 'desc';
        $query->orderBy('created_at', $direction);

        // Phân trang
        $comments = $query->paginate(10)
                          ->appends($request->only(['search','user_id','sort']));

        // Lấy danh sách user để hiển thị dropdown
        $users = User::orderBy('username')->get();

        return view('admin_dashboard.comments.index', compact('comments','users'));
    }

    /**
     * Xóa bình luận vĩnh viễn (admin) hoặc của chính user.
     */
    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        // Phân quyền: admin xoá mọi comment, user chỉ xoá comment của mình
        if ($user->role !== 'admin' && $user->id !== $comment->user_id) {
            abort(403, 'Bạn không có quyền xoá bình luận này.');
        }

        // Xóa cứng
        $comment->forceDelete();

        // Redirect hợp lý
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.comments.index')
                ->with('success', 'Đã xoá bình luận.');
        }

        return back()->with('success', 'Đã xoá bình luận.');
    }
}
