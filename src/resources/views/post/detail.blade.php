@extends('layout.master')
@section('title', 'top画面')

<link rel="stylesheet" href="{{ asset('/css/post-detail.css') }}">

@section('content')
@auth
@foreach ($posts as $post)
    <h1>{{ $post->title }}</h1>
@if (session('flashMessage'))
    <div class="flash_message">
        {{ session('flashMessage') }}
    </div>
@endif

    <div class="post-details">
        <p>{{ $post->users->name }}</p>
        <p>{{ $post->updated_at->format('Y-m-d') }}</p>
    </div>
    <form action="{{ route('Knowledge.edit', ['id' => $post->id ])}}" method="get">
        <button class="edit-button">編集</button>
    </form>
    <h3>Content</h3>
    <div class="content">
        {{ $post->content }}
    </div>

    @foreach ($postImages as $postImage)
        <div class="post-image">
            <p>[参考画像]</p>
            <img src="{{ Storage::url($postImage->img_path) }}" />
        </div>
    @endforeach
@endforeach
@endauth
@endsection
