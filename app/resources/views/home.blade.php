<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        initializeOrderRowClickEvents();
        highlightOrderFirstRow();
    });
</script>

<x-layout title="Home"> <!-- This Blade component refers to layout.blade.php. It's used to define reusable layout structure-->
    <h1 class="content-title">HOME</h1>
    <div class="content-container">
        <div id="home-content" class="main-content">
            <h1>Next 7 Days</h1>
            <x-order-table :orders="$orders[0]"/>
        </div>
        <div id="home-side-content" class="main-content">
            <h1>Recently Changed</h1>
            <x-order-table :orders="$orders[1]"/>
        </div>
    </div>
</x-layout>
