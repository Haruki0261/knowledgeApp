@extends('layout.master')
@section('title', 'top画面')

<link rel="stylesheet" href="{{ asset('/css/post-detail.css') }}">

@section('content')
@auth
@foreach($posts as $post)
<h1>{{ $post->title }}</h1>
<div class="post-details">
    <p>{{ $post->users->name }}</p>
    <p>{{ $post->updated_at }}</p>
</div>
<h3>Content</h3>
    <div class="content">
        {{ $post->content }}
    </div>
    @endforeach
    @foreach($postImages as $postImage)
    <div class="image">
        <p>[参考画像]</p>
        <img src="{{ Storage::url($postImage->img_path) }}" />
    </div>
@endforeach
@endauth
@endsection
