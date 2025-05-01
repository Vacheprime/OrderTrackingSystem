<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout title="Create Payment">
    <div class="layout-container">
        <div class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2 class="title">Create Payment</h2>
            <hr/>
            <form action="/payments/store" class="create-edit-form">
                <div class="flex-input-div">
                    <x-text-input-property labelText="Order ID" name="order-id"/>
                    <x-date-input-property labelText="Date" name="payment-date"/>
                    <x-text-input-property labelText="Amount" name="amount"/>
                    <x-text-input-property labelText="Type" name="type"/>
                    <x-text-input-property labelText="Method" name="method"/>
                </div>

                <div class="action-input-div">
                    <input class="regular-button" type="submit" value="Create"/>
                    <a href="/payments">
                        <button class="regular-button">Cancel</button>
                    </a>
               </div>
            </form>
        </div>
    </div>
</x-layout>
