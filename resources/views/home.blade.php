@extends('layouts.app')

@section('title', 'LehyUI')

@section('content')

@include('components.donate')

@include('components.header')



<main>

 
    @include('pages.homemain')
   

 

    @include('components.footer')
</main>
@endsection
