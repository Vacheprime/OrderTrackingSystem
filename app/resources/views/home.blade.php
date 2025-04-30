<link rel="stylesheet" href="{{ asset('css/home.css') }}">

<x-layout> <!-- This Blade component refers to layout.blade.php. It's used to define reusable layout structure-->
    <h1 class="content-title">HOME</h1>
    <div class="content-container">
        <div id="home-content" class="main-content">
            <h1>Next 7 Weeks</h1>
        </div>
        <div id="home-side-content" class="main-content">
            <h1>Recently Changed</h1>
        </div>
    </div>
</x-layout>
