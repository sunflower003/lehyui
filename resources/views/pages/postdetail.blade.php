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
            <p class="cr"><i class="ri-copyright-line"></i>20TH CENTURY FOX</p>
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
                            <span>28 June 2023</span>
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
                    <p class="current_blog">{{$post->title}}...</p>
                </div>







                <!-- Comment Section -->
                <div class="comment_section">
                   <h2>Comments <span class="comment_count">{{ $post->comments->count() }}</span></h2>

                    @if(Auth::check())
                        <form method="POST" action="{{ route('comments.store') }}">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="comment_input">
                                <textarea name="content" placeholder="Add comment..." rows="3" required></textarea>
                                <div class="comment_toolbar">
                                    <button type="button"><b>B</b></button>
                                    <button type="button"><i>I</i></button>
                                    <button type="button"><u>U</u></button>
                                    <button type="button"><i class="ri-image-line"></i></button>
                                    <button type="button"><i class="ri-link"></i></button>
                                    <button type="button"><i class="ri-emotion-line"></i></button>
                                    <button type="button"><i class="ri-at-line"></i></button>
                                    <button class="submit_btn" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p style="margin-top: 20px; font-size: 18px;">You need <a href="{{ route('login') }}">Sign In</a> to Comment.</p>
                    @endif
                
                    <div class="comments_display">
                        @foreach($post->comments->sortByDesc('created_at')->values() as $index => $comment)
                            <div class="comment {{ $index >= 3 ? 'hidden-comment' : '' }}">
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
                                </div>
                                <p class="comment_text">{{ $comment->content }}</p>
                                <div class="comment_actions" style="position: relative;">
                                    <span><i class="ri-thumb-up-line"></i></span>
                                    <span><i class="ri-thumb-down-line"></i></span>
                                    <span><i class="ri-chat-3-line"></i></span>

                                    @if(Auth::id() === $comment->user_id)
                                        <span class="comment_menu_toggle" data-id="menu-{{ $comment->id }}">
                                            <i class="ri-more-2-line"></i>
                                        </span>
                                        <div class="comment_menu hidden" id="menu-{{ $comment->id }}">
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="delete-comment">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($post->comments->count() > 3)
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
                    confirmButtonColor: '#d33',
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const comments = document.querySelectorAll('.comments_display .comment');
        const showMoreBtn = document.getElementById('showMoreBtn');
        let visibleCount = 3;

        if (showMoreBtn) {
            showMoreBtn.addEventListener('click', function () {
                const total = comments.length;
                const nextVisible = Math.min(visibleCount + 3, total);

                for (let i = visibleCount; i < nextVisible; i++) {
                    comments[i].classList.remove('hidden-comment');
                }

                visibleCount = nextVisible;

                if (visibleCount >= total) {
                    showMoreBtn.style.display = 'none';
                }
            });
        }
    });
</script>
