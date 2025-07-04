<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout title="Home">
    <!-- This Blade component refers to layout.blade.php. It's used to define reusable layout structure-->
    <h1 class="content-title">HOME</h1>
    <div class="content-container">
        <div id="home-content" class="main-content">
            <div class="home-header">
                <h2>Recently Viewed</h2>
            </div>
            <div class="table-content">
                <div class="search-table-div">
                    <x-order-table :orders="$orders[0]" :short="true"/>
                </div>
            </div>
        </div>
        <div id="home-side-content" class="main-content">
            <div class="home-header">
                <h2>Recently Changed</h2>
            </div>
            <div class="table-content">
                <div class="search-table-div">
                    <x-order-table :orders="$orders[1]" :short="true"/>
                </div>
            </div>
        </div>
    </div>
</x-layout>
