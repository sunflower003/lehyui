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


        public function show($id)
        {
            $post = Post::with(['user', 'category'])->findOrFail($id);

            // Tính số lượng từ và thời gian đọc với tiếng Anh
            $wordCount = str_word_count(strip_tags($post->body));


            $readingTime = max(1, ceil($wordCount / 200)); // trung bình 200 từ/phút

            // Lấy 3 bài viết liên quan cùng danh mục, trừ bài hiện tại
            $relatedPosts = Post::where('category_id', $post->category_id)
                                ->where('id', '!=', $post->id)
                                ->inRandomOrder()
                                ->take(3)
                                ->get();

            return view('pages.postdetail', [
                'post' => $post,
                'relatedPosts' => $relatedPosts,
                'readingTime' => $readingTime,
                'user' => $this->getProcessedUser(),
            ]);
        }
}