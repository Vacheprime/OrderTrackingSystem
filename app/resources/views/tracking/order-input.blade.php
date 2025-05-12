<link rel="stylesheet" href="{{ asset('css/trackinginput.css') }}">
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">

<x-layout title="Client Order Tracking">
    <div class="layout-container">
    <div id="track-content" class="content-container">
        <div class="main-content">
            <h2 id="titleOrder">ORDER TRACKING</h2>
            <p>Please enter your reference number to track your order status. If you need help finding it, check your confirmation email or contact our support team.</p>
            <div id="tracking-reference-div">
                <input type="text" placeholder="Reference Number"/>
            </div> 
            <a href="/tracking/display"><button class="regular-button">Track Order</button></a>
        </div>
    </div>
    </div>
</x-layout>
