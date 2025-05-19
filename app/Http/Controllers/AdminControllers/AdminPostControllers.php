<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class AdminPostControllers extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin_dashboard.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin_dashboard.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'nullable|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'body' => 'required',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Post::create($validated);
        return redirect()->route('admin.posts.index')->with('success', 'Đăng bài viết thành công!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin_dashboard.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'nullable|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'body' => 'required',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

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
