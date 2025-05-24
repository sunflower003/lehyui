<p>Xin chào {{ $parentUser->username }},</p>
<p>{{ $replyUser->username }} vừa trả lời bình luận của bạn trên bài viết: <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></p>
<blockquote style="border-left: 3px solid #999; margin: 8px 0; padding-left: 12px;">
    {{ $comment->content }}
</blockquote>
<p>Bấm vào <a href="{{ route('posts.show', $post->id) }}#comments">đây</a> để xem chi tiết.</p>
