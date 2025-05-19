@extends('layouts.app')

@section('title', 'LehyUI Blog')

@section('content')

@include('components.donate')

@include('components.header')



<main>

 
    @include('pages.homemain')
   

 

    @include('components.footer')
</main>
@endsection
