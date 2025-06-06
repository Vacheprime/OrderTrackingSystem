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
                    <x-date-input-property labelText="Date" name="payment-date" :value="old('payment-date-input', $payment->getPaymentDate()->format('Y-m-d'))"/>
                    <x-text-input-property labelText="Amount" name="amount" :value="old('amount', $payment->getAmount())"/>
                    <x-select-input-property labelText="Type" name="type">
                        <option value="DEPOSIT" {{ old('type', $payment->getType()) == \app\Doctrine\ORM\Entity\PaymentType::DEPOSIT ? "selected" : "" }}>DEPOSIT</option>
                        <option value="INSTALLMENT" {{ old('type', $payment->getType()) == \app\Doctrine\ORM\Entity\PaymentType::INSTALLMENT ? "selected" : "" }}>INSTALLMENT</option>
                    </x-select-input-property>
                    <x-text-input-property labelText="Method" name="method" :value="old('method', $payment->getMethod())"/>
                </div>
                <div class="action-input-div">
                    <button class="regular-button" type="submit">Save</button>
                    <a href="/payments" class="regular-button">Cancel</a>
               </div>
            </form>
        </div>
    </div>
</x-layout>
