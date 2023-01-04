@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', strip_tags(str_limit($post->text, 80, '...')))

@section('content')

    <div class="container">
        <h1 class="mt-5 mb-4">{{ $post->title }}</h1>
        <p class="lead">{!! $post->text !!}</p>
    </div>

@endsection
