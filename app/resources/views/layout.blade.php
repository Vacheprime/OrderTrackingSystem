@props(['title' => "Login Page"])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</head>
<body>
<x-header/>
<div class="main-layout">
{{--    @auth--}}
    <x-sidebar/>
{{--    @endauth--}}
    <main>
        {{$slot}}
    </main>
</div>
</body>
</html>
