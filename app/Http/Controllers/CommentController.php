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

        return redirect()->to(url()->previous() . '#comments')->with('success', 'Add comment successfully.');

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

        if ($user->role !== 'admin' && $user->id !== $comment->user_id) {
            abort(403, 'Bạn không có quyền xoá bình luận này.');
        }

        $comment->forceDelete();

        // Redirect tùy theo route đang gọi
        $routeName = request()->route()->getName();

        if (str_starts_with($routeName, 'admin.')) {
            return redirect()->route('admin.comments.index')->with('success', 'Delete comment successfully.');
        }

        return redirect()->to(url()->previous() . '#comments')->with('success', 'Delete comment successfully.');

    }
    public function update(Request $request, $id)
{
    $comment = Comment::findOrFail($id);

    if (Auth::id() !== $comment->user_id) {
        abort(403); // Không cho sửa nếu không phải chủ comment
    }

    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $comment->content = $request->input('content');
    $comment->save();

    return redirect()->back()->with('success', 'Comment updated successfully.');
}


}
