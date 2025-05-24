<div class="comment" style="margin-left: {{ 40 * $level }}px; {{ $level > 0 ? 'background: #f8f8ff; border-left: 3px solid #eee;' : '' }}">
    <div class="comment_header">
        @php
            $avatar = $comment->user->avatar && $comment->user->avatar !== 'avatar_default.jpg'
                ? asset('storage/avatars/' . $comment->user->avatar)
                : asset('img/avatar_default.jpg');
        @endphp
        <img src="{{ $avatar }}" class="avatar" alt="user">
        <div>
            <p class="username">{{ $comment->user->username }}</p>
            <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        <div class="comment_actions">
            @if(Auth::id() === $comment->user_id)
                <span class="comment_menu_toggle" data-id="menu-{{ $comment->id }}">
                    <i class="ri-more-2-line"></i>
                </span>
                <div class="comment_menu hidden" id="menu-{{ $comment->id }}">
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="delete-comment">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn_comment_delete">Delete</button>
                    </form>
                    <button type="button" class="btn_comment_edit">Edit</button>
                    <div class="comment_menu_arrow"></div>
                </div>
            @endif
        </div>
    </div>
    <p class="comment_text" id="comment-text-{{ $comment->id }}">{{ $comment->content }}</p>
    {{-- Like/dislike & edit --}}
    <div class="comment_like_actions" style="margin: 8px 0 0 0;">
        <form action="{{ route('comments.like', $comment->id) }}#comments" method="POST" style="display:inline;">
            @csrf
            <button type="submit"
                @if(Auth::check() && $comment->likes->where('user_id', Auth::id())->count())
                    style="color: #2196F3; font-weight: bold;"
                @endif
                title="Like"
            >👍 {{ $comment->likes->count() }}</button>
        </form>
        <form action="{{ route('comments.dislike', $comment->id) }}#comments" method="POST" style="display:inline;">
            @csrf
            <button type="submit"
                @if(Auth::check() && $comment->dislikes->where('user_id', Auth::id())->count())
                    style="color: #e74c3c; font-weight: bold;"
                @endif
                title="Dislike"
            >👎 {{ $comment->dislikes->count() }}</button>
        </form>
    </div>
    <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="edit-comment-form hidden" id="edit-form-{{ $comment->id }}">
        @csrf
        @method('PUT')
        <textarea name="content" rows="3" required>{{ $comment->content }}</textarea>
        <div style="margin-top: 8px;" class="save_cancel">
            <button type="submit" class="btn_comment_submit">Save</button>
            <button type="button" class="btn_comment_cancel" data-id="{{ $comment->id }}">Cancel</button>
        </div>
    </form>

    {{-- Nút trả lời + form trả lời --}}
    @auth
    <button class="reply-btn" data-id="{{ $comment->id }}" style="font-size: 13px; margin-left: 10px; color: #0066ff; background: none; border: none; cursor: pointer;">Reply</button>
    <form class="reply-form hidden" id="reply-form-{{ $comment->id }}" method="POST" action="{{ route('comments.store') }}">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea name="content" rows="2" placeholder="Write something..." required style="width: 90%;"></textarea>
        <button type="submit" class="submit_btn" style="padding: 3px 12px; margin-top: 2px;">Send</button>
        <button type="button" class="cancel-reply-btn" data-id="{{ $comment->id }}" style="padding: 3px 10px; background: #eee; border: none;">cancel</button>
    </form>
    @endauth

    {{-- ĐỆ QUY HIỂN THỊ REPLY --}}
    @if($comment->repliesRecursive && $comment->repliesRecursive->count())
        @foreach($comment->repliesRecursive as $reply)
            @include('components.comment_item', ['comment' => $reply, 'level' => $level + 1, 'post' => $post])
        @endforeach
    @endif
</div>
