<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        {{-- font --}}
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/top.css') }}">
</head>
<body>
    <aside class="left-side-bar">
        <form method="GET" action="{{ route('Knowledge.index') }}" >
            <button class="home-button">Home</button>
        </form>
        <button class="trush-button">g</button>
    </aside>
    <div class="flex-column">
        <header>
            <div class="user-name">
                {{ Auth::user()->name}}
            </div>
            <form method="GET" action="{{ route('Knowledge.create') }}" >
                <button class="post-button">投稿</button>
            </form>
        </header>
        <main>
            @yield('content')
        </main>
    </div>
</body>
