@extends('layouts.app')

@section('title', 'LehyUI')

@section('content')

@include('components.donate')

@include('components.header')



<main>

 
    @include('pages.homemain')
   

 

    
</main>
@include('components.footer')
@endsection
