<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class AdminPostControllers extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()->with('category', 'user');

        // Tìm kiếm theo tiêu đề
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sắp xếp theo thời gian
        if ($request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        if ($request->sort == 'title') {
            $query->orderBy('title', 'asc');
        }

        $posts = $query->paginate(5)->appends($request->query());
        $categories = Category::all();
        //$posts = Post::latest()->get();
        return view('admin_dashboard.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin_dashboard.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'nullable|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = auth()->id(); // không lấy từ form
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Post::create($validated);
        return redirect()->route('admin.posts.index')->with('success', 'Đăng bài viết thành công!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all(); // ← Bắt buộc phải có dòng này

        return view('admin_dashboard.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'nullable|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        $validated['user_id'] = auth()->id();
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $post->update($validated);
        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('admin.posts.index')->with('success', 'Xoá bài viết thành công!');
    }
}
