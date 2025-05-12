<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout title="Edit Payment">
    <div class="layout-container">
        <div class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2 class="title">Edit Payment</h2>
            <hr/>
            <form method="POST" action="{{route("payments.update", $payment->getPaymentId())}}" class="create-edit-form">
                @csrf
                @method("PUT")
                <div class="flex-input-div">
                    <x-text-input-property labelText="Order ID" name="order-id"/>
                    <x-date-input-property labelText="Date" name="payment-date"/>
                    <x-text-input-property labelText="Amount" name="amount"/>
                    <x-text-input-property labelText="Type" name="type"/>
                    <x-text-input-property labelText="Method" name="method"/>
                </div>

                <div class="action-input-div">
                    <button class="regular-button" type="submit">Save</button>
                    <a href="/payments" class="regular-button">Cancel</a>
               </div>
            </form>
        </div>
    </div>
</x-layout>
