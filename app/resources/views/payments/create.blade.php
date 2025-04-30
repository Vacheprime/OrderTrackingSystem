<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout title="Create Payment">
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}">
                <button>Go Back</button>
            </a>
            <form action="/payments/store" class="create-edit-form">
                <h2 class="title">Create Payment</h2>
                <x-text-input-property labelText="Order ID" name="order-id"/>
                <x-date-input-property labelText="Date" name="payment-date"/>
                <x-text-input-property labelText="Amount" name="amount"/>
                <x-text-input-property labelText="Type" name="type"/>
                <x-text-input-property labelText="Method" name="method"/>
                <input class="regular-button" type="submit" value="Create"/>
            </form>
            <a href="/payments">
                <button class="regular-button">Cancel</button>
            </a>
        </div>
    </div>
</x-layout>
