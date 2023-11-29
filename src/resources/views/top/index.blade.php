@extends('layout.master')
@section('title', 'top画面')

@section('content')
@if (session('flash_message'))
    <div class="flash_message">
        {{ session('flash_message') }}
    </div>
@endif
@endsection
