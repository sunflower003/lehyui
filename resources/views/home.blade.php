@extends('layouts.app')

@section('title', 'LehyUI Blog')

@section('content')

@include('components.donate')

@include('components.header')



<main>

    @if (!isset($showCategoryPage))
        @include('pages.homemain')
    @else
        @include('pages.categorypost')
    @endif

 

    @include('components.footer')
</main>
@endsection
