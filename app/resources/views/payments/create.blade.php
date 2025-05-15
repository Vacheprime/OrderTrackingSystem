<link rel="stylesheet" href="{{ asset('css/payments.css') }}">

<x-layout title="Create Payment">
    <h1 class="content-title">CREATING PAYMENT</h1>
    <div class="content-container">
        <div id="payment-create-content" class="main-content">
            <div class="create-edit-header">
                <a href="{{$orderId == "" ? "/payments" : "/orders"}}" class="regular-button">Go Back</a>
                <h2>Payment Information</h2>
                <div class="filler-div"></div>
            </div>
            <form method="POST" action="/payments" class="create-edit-form">
                @csrf
                <div class="details-div">
                    <x-text-input-property labelText="Order ID" name="order-id" :value="$orderId"/>
                    <x-date-input-property labelText="Date" name="payment-date"/>
                    <x-text-input-property labelText="Amount" name="amount"/>
                    <x-text-input-property labelText="Type" name="type"/>
                    <x-text-input-property labelText="Method" name="method"/>
                </div>

                <div class="action-input-div">
                    <button class="regular-button" type="submit">Create</button>
                    <a href="/payments" class="regular-button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
