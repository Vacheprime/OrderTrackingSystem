<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<x-header :loggedin="{{--TODO: Implement authorization--}}}"/>
@if($loggedin)
    <x-sidebar :admin="{{--TODO: Implement authorization--}}"/>
@endif
<main>
    {{$slot}}
</main>
</body>
</html>
