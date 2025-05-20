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
                    <h2>Comments <span class="comment_count">25</span></h2>
                    
                    <div class="comment_input">
                        <textarea placeholder="Add comment..." rows="3"></textarea>
                        <div class="comment_toolbar">
                            <button><b>B</b></button>
                            <button><i>I</i></button>
                            <button><u>U</u></button>
                            <button><i class="ri-image-line"></i></button>
                            <button><i class="ri-link"></i></button>
                            <button><i class="ri-emotion-line"></i></button>
                            <button><i class="ri-at-line"></i></button>
                            <button class="submit_btn">Submit</button>
                        </div>
                    </div>

                    <div class="comments_display">
                        <!-- Comment 1 -->
                        <div class="comment">
                            <div class="comment_header">
                                <img src="img/avatar.jpg" class="avatar" alt="user">
                                <div>
                                    <p class="username">Noah Pierre</p>
                                    <span class="time">58 minutes ago</span>
                                </div>
                            </div>
                            <p class="comment_text">I’m a bit unclear about how condensation forms in the water cycle. Can someone break it down?</p>
                            <div class="comment_actions">
                                <span><i class="ri-thumb-up-line"></i> 25</span>
                                <span><i class="ri-thumb-down-line"></i></span>
                                <span><i class="ri-chat-3-line"></i> 3</span>
                                <span><i class="ri-more-2-line"></i></span>
                            </div>

                        </div>

                        
                    </div>
                    <div class="show_more">Show more<i class="ri-arrow-down-line"></i></div>
                </div>


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