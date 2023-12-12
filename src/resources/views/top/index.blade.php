@extends('layout.master')
@section('title', 'top画面')

<link rel="stylesheet" href="{{ asset('/css/index.css') }}">

@section('content')
@auth
<h1>投稿一覧</h1>
@if (session('flash_message'))
    <div class="flash_message">
        {{ session('flash_message') }}
    </div>
@endif
@foreach($posts as $post)
    <a href="{{ route('Knowledge.detail', ['id' => $post->id]) }}">
        <div class="card">
            <div class="post-name">
                {{ $post->users->name }}
            </div>
            <div class="post-time">
                {{ $post->updated_at->format('Y-m-d')}}
            </div>
            <div class="post-title">
                {{ $post->title }}
            </div>
        </div>
    </a>
@endforeach
@endauth
@endsection
