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
    {{ $posts->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>


</main>
@include('components.footer')
@endsection
