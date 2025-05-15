<link rel="stylesheet" href="{{ asset('css/trackinginput.css') }}">
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">

<x-tracking-layout title="Client Order Tracking">
    <div class="layout-container">
    <div id="track-content" class="content-container">
        <div class="main-content">
            <h2 id="titleOrder">ORDER TRACKING</h2>
            <p>Please enter your reference number to track your order status. If you need help finding it, check your confirmation email or contact our support team.</p>
            <form action="/tracking" method="POST">
                @csrf
                <div id="tracking-reference-div">
                    <x-text-input-property name="reference-number" :isLabel="false" labelText="Reference Number"/>
                </div>
                <button class="regular-button" type="submit">Track Order</button>
            </form>
        </div>
    </div>
    </div>
</x-tracking-layout>
