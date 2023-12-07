@extends('layout.master')
@section('title', 'top画面')

<link rel="stylesheet" href="{{ asset('/css/post-detail.css') }}">
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


@section('content')
@auth
@foreach ($posts as $post)
    <h1>{{ $post->title }}</h1>
@if (session('flashMessage'))
    <div class="flash_message">
        {{ session('flashMessage') }}
    </div>
@endif
<div class="post-container">
    <div class="post-details">
            <p>{{ $post->users->name }}</p>
            <p>{{ $post->updated_at->format('Y-m-d') }}</p>
    </div>
    <div class="post-actions">
        <form action="{{ route('Knowledge.edit', ['id' => $post->id ])}}" method="get">
            @csrf
            <button class="action-button edit-button">編集</button>
        </form>
        <!-- Button trigger modal -->
        <button type="button" class="action-button delete-button" data-bs-toggle="modal" data-bs-target="#deleteModal">
        削除
        </button>
    </div>
</div>

    <h3>Content</h3>
    <div class="content">
        {{ $post->content }}
    </div>

    @foreach ($postImages as $postImage)
        <div class="post-image">
            <p>[参考画像]</p>
            <img src="{{ Storage::url($postImage->img_path) }}" />
        </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header d-block text-center">
                <h1 class="modal-title fs-5 text" id="exampleModalLabel">削除確認</h1>
            </div>
            <div class="modal-body text-center">
                本当に削除しても大丈夫ですか？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                <form action="{{ route('Knowledge.delete', ['id' => $post->id ])}}" method="post">
                    @csrf
                    @method('delete')
                <button class="btn btn-danger">削除</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endforeach
@endauth
@endsection
