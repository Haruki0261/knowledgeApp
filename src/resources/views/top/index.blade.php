@extends('layout.master')
@section('title', 'top画面')

<link rel="stylesheet" href="{{ asset('/css/index.css') }}">

@section('content')
@auth
@if (session('flash_message'))
    <div class="flash_message">
        {{ session('flash-message') }}
    </div>
@endif
<h1>投稿一覧</h1>
@foreach($posts as $post)
    <a href="{{ route('Knowledge.detail', ['id' => $post->id]) }}" class="">
        <div class="card">
            <div class="post-name">
                {{ $post->users->name }}
            </div>
            <div class="post-time">
                {{ $post->updated_at}}
            </div>
            <div class="post-title">
                {{ $post->title }}
            </div>
        </div>
    </a>
@endforeach
@endauth
@endsection
