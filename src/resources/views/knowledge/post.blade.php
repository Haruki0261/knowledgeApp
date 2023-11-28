@extends('layout.master')
@section('title', '新規投稿画面')

<link rel="stylesheet" href="{{ asset('/css/post.css') }}">

@section('content')
    <h1>新規投稿機能</h1>
    @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
    <form action="{{ route('Knowledge.createPost')}}" method="post" enctype='multipart/form-data'>
        @csrf
        <label for="title">Title</label>
        <input type="text" class="title" name="title">
        <label for="posts">Content</label>
        <textarea name="content"></textarea>
        <input type="file" name="images[]" multiple/>
        <button type="submit" class="send-button">送信</button>
    </form>

@endsection
