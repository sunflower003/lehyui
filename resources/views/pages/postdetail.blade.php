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
                            <span>{{ $post->created_at->format('d F Y') }}</span>
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
                <div class="comment_section" id="comments">
                   <h2>Comments <span class="comment_count">{{ $post->comments->count() }}</span></h2>

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
                                                

                                                <!-- Mũi tên nhỏ -->
                                                <div class="comment_menu_arrow"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <p class="comment_text" id="comment-text-{{ $comment->id }}">{{ $comment->content }}</p>

                                <!-- Form chỉnh sửa bình luận (ẩn mặc định) -->
                                <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="edit-comment-form hidden" id="edit-form-{{ $comment->id }}">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="content" rows="3" required>{{ $comment->content }}</textarea>
                                    <div style="margin-top: 8px;">
                                        <button type="submit" class="btn_comment_submit">Save</button>
                                        <button type="button" class="btn_comment_cancel" data-id="{{ $comment->id }}">Cancel</button>
                                    </div>
                                </form>

                                
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

<!-- Thêm đoạn này -->
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

