@props(['title' => "Tracking Order"])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <script src="{{ asset('js/main.js') }}"></script>
</head>
<body>
<x-header :logout="false" :language="true"/>
<div class="main-layout">
    <main>
        {{$slot}}
    </main>
</div>
</body>
</html>
