<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        initializeOrderRowClickEvents();
        highlightOrderFirstRow();
    });
</script>

<x-layout title="Home">
    <!-- This Blade component refers to layout.blade.php. It's used to define reusable layout structure-->
    <h1 class="content-title">HOME</h1>
    <div class="content-container">
        <div id="home-content" class="main-content">
            <div class="home-header">
                <h2>Next 7 Days</h2>
                <a href="" class="regular-button">View Table</a>
            </div>
            <x-order-table :orders="$orders[0]"/>
        </div>
        <div id="home-side-content" class="main-content">
            <div class="home-header">
                <h2>Recently Changed</h2>
                <a href="" class="regular-button">View Table</a>
            </div>
            <x-order-table :orders="$orders[1]"/>
        </div>
    </div>
</x-layout>
