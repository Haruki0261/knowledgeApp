@extends('layout.master')
@section('title', '投稿編集画面')

<link rel="stylesheet" href="{{ asset('/css/post.css') }}">

@section('content')
@auth
<h1>投稿編集</h1>
@foreach ($errors->all() as $error)
    <li>{{$error}}</li>
@endforeach
    @foreach($posts as $post)
        <form action="{{ route('Knowledge.update', ['id' => $post->id ])}}" method="post" enctype='multipart/form-data'>
            @csrf
            @method('put')
            <label for="title">Title</label>
            <input type="text" class="title" name="title" value={{ $post->title }}>
            <label for="posts">Content</label>
            <textarea name="content">{{ $post->content }}</textarea>
            <input type="file" name="images[]" multiple/>
            <button type="submit" class="send-button">送信</button>
        </form>
    @endforeach
@endauth
@endsection
