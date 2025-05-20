@extends('layouts.app')

@section('title', 'All Categories - LehyUI')

@section('content')
@include('components.donate')
@include('components.header')

<main>
    <div class="container all_container">
        <h2 class="title_head">All Categories</h2>
        <ul class="all_categories_menu">
            @foreach($categories as $category)
                <li class="all_categories_item">
                    <a href="{{ route('category.posts', $category->id) }}" class="all_categories_link">{{ $category->name }}</a>
                    <span>- {{ $category->posts_count }} posts</span>
                </li>
            @endforeach
        </ul>
    </div>
</main>

@include('components.footer')
@endsection
