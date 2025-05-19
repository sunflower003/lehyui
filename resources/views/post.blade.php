{{-- filepath: resources/views/post.blade.php --}}
@extends('layouts.app')

@section('title', $post->title ?? 'Post')

@section('content')
@include('components.header')
@include('components.donate')
<main>
    <div class="container header_container">
        <div class="pin">
            <span class="pin_tag">{{ $post->category->name ?? 'Uncategorized' }}</span>
            <span class="pin_time">{{ round(str_word_count(strip_tags($post->body ?? ''))/200) }} min read</span>
        </div>
        <div class="header_title">
            <h1>{{ $post->title }}</h1>
            <span><img src="{{ $post->user->avatar ?? asset('img/avatar_default.jpg') }}" alt="" class="avatar">by {{ $post->user->username ?? 'Unknown' }}</span>
        </div>
    </div>
    <div class="container image_header">
        @if($post->thumbnail)
            <img src="{{ asset($post->thumbnail) }}" alt="thumbnail">
        @endif
        <div class="header_content">
            @if($post->sub_title)
                <h1>{{ $post->sub_title }}</h1>
            @endif
            <p>- {{ $post->user->username ?? 'Lehy' }}</p>
        </div>
    </div>
    <div class="container content_container">
        <div class="left_col">
            {!! $post->body !!}
        </div>
        <div class="right_col">
            <h1>More from our blog</h1>
            <div class="blog_card_list">
                @foreach($morePosts as $item)
                    @if($item->id !== $post->id)
                    <div class="blog_card" style="margin-bottom:2rem;">
                        <a href="{{ route('post.show', $item->id) }}" style="display:flex;align-items:center;gap:1.2rem;text-decoration:none;color:inherit;">
                            <img src="{{ $item->thumbnail ? asset($item->thumbnail) : asset('img/img2.jpg') }}" alt="thumbnail" style="width:70px;height:70px;object-fit:cover;border-radius:8px;">
                            <div class="card_detail">
                                <div class="title_card" style="font-size:1.4rem;font-weight:600;">{{ $item->title }}</div>
                                <div class="subtitle_card" style="font-size:1.2rem;color:#888;">{{ $item->sub_title ?? Str::limit(strip_tags($item->body), 60) }}</div>
                            </div>
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- Comment Section -->
    <div class="container" style="margin-top: 4rem;">
        <h2 style="font-size:2.2rem;font-weight:700;display:inline-block;">Comments <span style="background:#ff8000;color:#fff;border-radius:1.2rem;padding:0.2rem 1.2rem;font-size:1.5rem;vertical-align:middle;">25</span></h2>
        <form style="margin-top:2rem;">
            <textarea placeholder="Add comment..." style="width:100%;height:100px;border-radius:8px;border:1px solid #eee;padding:1rem;font-size:1.5rem;"></textarea>
            <div style="margin-top:1rem;display:flex;align-items:center;gap:0.5rem;">
                <button type="button" style="font-weight:700;font-size:1.5rem;padding:0.5rem 1.2rem;border-radius:6px;border:none;background:#eee;">B</button>
                <button type="button" style="font-style:italic;font-size:1.5rem;padding:0.5rem 1.2rem;border-radius:6px;border:none;background:#eee;">I</button>
                <button type="button" style="text-decoration:underline;font-size:1.5rem;padding:0.5rem 1.2rem;border-radius:6px;border:none;background:#eee;">U</button>
                <button type="button" style="font-size:1.5rem;padding:0.5rem 1.2rem;border-radius:6px;border:none;background:#eee;">🖼️</button>
                <button type="button" style="font-size:1.5rem;padding:0.5rem 1.2rem;border-radius:6px;border:none;background:#eee;">🔗</button>
                <button type="button" style="font-size:1.5rem;padding:0.5rem 1.2rem;border-radius:6px;border:none;background:#eee;">😊</button>
                <button type="button" style="font-size:1.5rem;padding:0.5rem 1.2rem;border-radius:6px;border:none;background:#eee;">@</button>
                <button type="submit" style="background:#ff8000;color:#fff;font-weight:600;font-size:1.5rem;padding:0.5rem 2rem;border-radius:6px;border:none;margin-left:1rem;">Submit</button>
            </div>
        </form>
        <div style="margin-top:2.5rem;background:#fff;border-radius:12px;padding:2rem 2.5rem;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:1.2rem;">
                <img src="{{ asset('img/avatar.jpg') }}" alt="avatar" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                <div>
                    <span style="font-weight:700;font-size:1.6rem;">Noah Pierre</span><br>
                    <span style="color:#888;font-size:1.2rem;">58 minutes ago</span>
                </div>
            </div>
            <div style="margin-top:1.2rem;font-size:1.5rem;">I'm a bit unclear about how condensation forms in the water cycle. Can someone break it down?</div>
            <div style="margin-top:1.2rem;display:flex;align-items:center;gap:2rem;color:#888;font-size:1.4rem;">
                <span>👍25</span>
                <span>👎</span>
                <span>💬3</span>
                <span>⋯</span>
            </div>
        </div>
        <div style="text-align:center;margin-top:2rem;">
            <a href="#" style="color:#ff8000;font-size:1.6rem;font-weight:600;text-decoration:none;">Show more <span style="font-size:2rem;vertical-align:middle;">↓</span></a>
        </div>
    </div>
</main>
@include('components.footer')
@endsection
