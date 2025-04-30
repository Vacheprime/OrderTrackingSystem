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
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</head>
<body>
<x-header/>
<div class="main-layout">
{{--    @auth--}}  <!-- This is to show content only when authenticated--> 
    <x-sidebar/>
{{--    @endauth--}}
    <main>
        {{$slot}} <!-- The content injected into slot depends on the child view or component that uses layout.blade.php.-->
    </main>
</div>
</body>
</html>
