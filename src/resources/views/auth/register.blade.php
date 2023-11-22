<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Register</title>
        <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
        {{-- font --}}
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="login-card">
    <h1>ナレッジアプリ</h1>
        <div class="login">ログイン</div>
        <div class="login-button">
            <a href="{{ route("sns.redirect", "slack") }}">
                @include('slack-icon')
                Sign in with Slack
            </a>
            <a href="{{ route("sns.redirect", "google")}}">
                @include('google-icon')
                Sign in with Google
            </a>
        </div>
    </div>
</body>
</html>
