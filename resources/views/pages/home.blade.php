@extends('layouts.app')
@section('head_tags')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
@section('content')

    <!-- SSR component -->
    <div>
        <h1>Home page</h1>
        <h1>Home page</h1>
    </div>


    <div id="featured-posts">
        <!-- Vue component rendered from API -->
        <featured-posts></featured-posts>
    </div>

{{--    <div id="testimonials">--}}
{{--        <testimonials></testimonials>--}}
{{--    </div>--}}

@endsection
