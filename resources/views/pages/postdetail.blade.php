@extends('layouts.app') 

@section('title', 'All ' . $post->title . ' - LehyUI')

@section('content')

@include('components.donate')
@include('components.header')
@php
    $author = $post->user;
    $authorAvatar = $author->avatar && $author->avatar !== 'avatar_default.jpg'
        ? asset('storage/avatars/' . $author->avatar)
        : asset('img/avatar_default.jpg');
@endphp
<main>

<div class="container header_container">
            <div class="pin">
                <span class="pin_tag">{{$post->category->name}}</span>
                <span class="pin_time">{{ $readingTime }} min read</span>
            </div>
            <div class="header_title">
                <h1>{{$post->title}}</h1>
                <span><img src="{{ $authorAvatar }}" alt="" class="profile_avatar">by {{$post->user->username}}</span></span>
            </div>
        </div>
        <div class="container image_header">
            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
            <p class="cr"><i class="ri-copyright-line"></i>20TH CENTURY LEHYUI</p>
            <div class="header_content">
                <h1>{{$post->title}}</h1>
                <p>- {{$post->user->username}}</p>
            </div>
            
        </div>
        <div class="container content_container">
            <div class="left_col">
                <div class="content_post_detail">
                    {!! $post->body !!}
                </div>
                
                <div class="about_me">
                    <div class="detail_author">
                       <img src="{{ $authorAvatar }}" alt="" class="profile_avatar">
                       <div class="name">
                            <p>{{$post->user->username}}</p>
                            <span>
                                @if ($post->created_at->diffInHours(now()) < 24)
                                    {{ $post->created_at->diffForHumans() }}
                                @else
                                    {{ $post->created_at->format('d M Y') }}
                                @endif
                            </span>
                       </div>
                    </div>
                    <div class="info">
                        <a href="https://www.facebook.com/lehyyy/" class="info_sci" target="_blank"><i class="ri-facebook-circle-fill"></i></a>
                        <a href="https://twitter.com/lehyyy_" class="info_sci" target="_blank"><i class="ri-twitter-fill"></i></a>
                        <a href="https://www.instagram.com/_lehyyy/" class="info_sci" target="_blank"><i class="ri-instagram-line"></i></a>
                        
                    </div>
                </div>
                <div class="link_blog">
                    <p>LehyUI<i class="ri-arrow-right-s-line"></i></p>
                    <p>Blog<i class="ri-arrow-right-s-line"></i></p>
                    <p>{{$post->category->name}}<i class="ri-arrow-right-s-line"></i></p>
                    <p class="current_blog">{{$post->title}}</p>
                </div>







                <!-- Comment Section -->
                <div class="comment_section" id="comments">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h2>Comments <span class="comment_count">{{ $comments->count() }}</span></h2>
                        <form method="GET" action="#comments" style="margin: 0; display: flex; align-items: center; gap: 12px;">
                            <label for="order" style="font-size: 14px;">Sort by:</label>
                            <select name="order" id="order" onchange="this.form.submit()" style="font-size: 15px; padding: 2px 8px; border-radius: 6px;">
                                <option value="newest" {{ $order === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="oldest" {{ $order === 'oldest' ? 'selected' : '' }}>Oldest</option>
                            </select>
                        </form>
                    </div>
                    
                        @if(Auth::check())
                        <form method="POST" action="{{ route('comments.store') }}">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="comment_input">
                                <textarea name="content" placeholder="Add comment..." rows="3" required></textarea>
                                <div class="comment_toolbar">
                                    <button class="submit_btn" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p style="margin-top: 20px; font-size: 18px;">You need <a href="{{ route('login') }}">Sign In</a> to Comment.</p>
                    @endif
                
                    <div class="comments_display">
                        @foreach($comments as $comment)
                                @include('components.comment_item', ['comment' => $comment, 'level' => 0, 'post' => $post])
                        @endforeach
                    </div>

                    @if($comments->count() > 3)
                        <div class="show_more" id="showMoreBtn" style="cursor: pointer; margin-top: 20px; font-weight: bold;">
                            Show more <i class="ri-arrow-down-line"></i>
                        </div>
                    @endif


                </div>
                

                <!-- End Comment Section -->



            </div>
            <div class="right_col">
                <h1>More from {{$post->category->name}}</h1>
                @foreach($relatedPosts as $related)
                    <a href="{{ url('/posts/' . $related->id) }}" class="blog_card">
                        <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="blog">
                        <div class="card_detail">
                            <div class="title_card">
                                <h2>{{ $related->title }}</h2>
                                <i class="ri-arrow-right-up-line"></i>
                            </div>
                            <p class="subtitle_card">{{ Str::limit($related->sub_title, 100) }}</p>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('category.posts', $post->category->id) }}" class="bt">See all {{ $post->category->name }} posts</a>
            </div>
        </div>

</main>
@include('components.footer')


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bắt sự kiện nút Edit
    document.querySelectorAll('.btn_comment_edit').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.closest('.comment_actions')
                                    .querySelector('.comment_menu_toggle')
                                    .dataset.id.split('-')[1];
            document.getElementById('edit-form-' + commentId).classList.remove('hidden');
            document.getElementById('comment-text-' + commentId).style.display = 'none';
        });
    });

    // Bắt sự kiện nút Cancel
    document.querySelectorAll('.btn_comment_cancel').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            document.getElementById('edit-form-' + id).classList.add('hidden');
            document.getElementById('comment-text-' + id).style.display = '';
        });
    });

    // Script hiện/ẩn form trả lời
    document.querySelectorAll('.reply-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            document.getElementById('reply-form-' + id).classList.remove('hidden');
        });
    });
    document.querySelectorAll('.cancel-reply-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            document.getElementById('reply-form-' + id).classList.add('hidden');
        });
    });
    document.querySelectorAll('.show-more-reply-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            document.querySelectorAll('.hidden-reply-' + id).forEach(function(div) {
                div.style.display = 'block';
            });
            this.style.display = 'none';
        });
    });
});
</script>

@endsection


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-comment');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Ngăn form gửi ngay

                Swal.fire({
                    title: 'You want to delete this comment?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Gửi form nếu xác nhận
                    }
                });
            });
        });
    });
</script>