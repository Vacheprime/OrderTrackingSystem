<link rel="stylesheet" href="{{ asset('css/ordertracking.css') }}">

<x-tracking-layout title="Client Order Tracking">
    <!-- <div class="layout-container"> -->
    <div class="content-container">
        <div class="main-content">
            <h2>ORDER TRACKING</h2>
            <p>Please enter your reference number to track your order status. If you need help finding it, check your confirmation email or contact our support team.</p>
            <div id="tracking-reference-div">
                <x-text-input-property labelText="Reference Number" name="reference-number"/>
            </div>
            <a href="/tracking/display"><button class="regular-button">Track Order</button></a>
        </div>
    </div>
    <!-- </div> -->
</x-tracking-layout>
