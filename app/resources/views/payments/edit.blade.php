<link rel="stylesheet" href="{{ asset('css/payments.css') }}">

<x-layout title="Edit Payment">
    <h1 class="content-title">EDIT PAYMENT</h1>
    <div class="content-container">
        <div id="payment-create-content" class="main-content">
            <div class="create-edit-header">
                <a href="/payments" class="regular-button">Go Back</a>
                <h2>Payment Information</h2>
                <div class="filler-div"></div>
            </div>
            <form method="POST" action="{{route("payments.update", $payment->getPaymentId())}}" class="create-edit-form">
                @csrf
                @method("PUT")
                <div class="details-div">
                    <x-text-input-property labelText="Order ID" name="order-id" :value="$payment->getOrder()->getOrderId()"/>
                    <x-date-input-property labelText="Date" name="payment-date" :value="$payment->getPaymentDate()->format('Y-m-d')"/>
                    <x-text-input-property labelText="Amount" name="amount" :value="$payment->getAmount()"/>
                    <x-text-input-property labelText="Type" name="type" :value="$payment->getType()"/>
                    <x-text-input-property labelText="Method" name="method" :value="$payment->getMethod()"/>
                </div>
                <div class="action-input-div">
                    <button class="regular-button" type="submit">Save</button>
                    <a href="/payments" class="regular-button">Cancel</a>
               </div>
            </form>
        </div>
    </div>
</x-layout>
