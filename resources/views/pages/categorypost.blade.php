@extends('layouts.app')

@section('title', 'All ' . $category->name . ' posts - LehyUI')

@section('content')

@include('components.donate')
@include('components.header')

<main>

    <div class="container all_container">
        <h2 class="title_head">All {{ $category->name }} posts</h2>

        @if ($posts->isEmpty())
            <div class="no_posts">
                <p>There are no posts in <strong>{{ $category->name }}</strong> .</p>
            </div>
        @else
            <div class="grid_posts">
                @foreach($posts as $post)
                    <a href="{{ url('/posts/' . $post->id) }}" class="grid_card">
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="image">
                        <div class="card_details">
                            <p class="author_time">
                                {{ $post->user->username ?? 'Unknown' }} 
                                <i class="ri-checkbox-blank-circle-fill"></i> 
                                {{ $post->created_at->format('d M Y') }}
                            </p>
                            <h2 class="title_card">
                                {{ $post->title }} <i class="ri-arrow-right-up-line"></i>
                            </h2>
                            <p class="subtitle">{{ $post->sub_title }}</p>
                            <div class="tags">
                                <span class="tag">{{ $category->name }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="container pagination">
        <span class="previous"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg> Previous</span>
        <ul>
            <li class="current">1</li>
            <li>2</li>
            <li>3</li>
            <li class="dot">...</li>
            <li>8</li>
            <li>9</li>
            <li>10</li>
        </ul>
        <span class="after">Next<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg></i></span>
    </div>
@include('components.footer')
</main>
@endsection