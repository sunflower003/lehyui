<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
class PostController extends Controller
{
        public function byCategory($id)
        {
            $category = Category::findOrFail($id);

            $posts = Post::where('category_id', $id)
                        ->latest()
                        ->with('user')
                        ->paginate(6); // ← Mỗi trang 6 bài

            return view('pages.categorypost', [
                'category' => $category,
                'posts' => $posts,
                'user' => $this->getProcessedUser(),
            ]);
        }


        public function show($id, Request $request)
{
    $post = Post::with(['user', 'category'])->findOrFail($id);

    $wordCount = str_word_count(strip_tags($post->body));
    $readingTime = max(1, ceil($wordCount / 200));

    $relatedPosts = Post::where('category_id', $post->category_id)
        ->where('id', '!=', $post->id)
        ->inRandomOrder()
        ->take(3)
        ->get();

    // Lọc bình luận cha, lấy replies, giữ logic sort
    $order = $request->query('order', 'newest');
    $comments = $post->comments()
        ->with([
            'user',
            'repliesRecursive.user',
            'likes',
            'dislikes',
            'repliesRecursive.likes',
            'repliesRecursive.dislikes'
        ])
        ->whereNull('parent_id')
        ->orderBy('created_at', $order === 'oldest' ? 'asc' : 'desc')
        ->get();

    return view('pages.postdetail', [
        'post' => $post,
        'relatedPosts' => $relatedPosts,
        'readingTime' => $readingTime,
        'user' => $this->getProcessedUser(),
        'comments' => $comments,
        'order' => $order,
    ]);
}

}