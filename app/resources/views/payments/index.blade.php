<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>

<x-layout title="Payment Management">
    <h1 class="content-title">PAYMENT MANAGEMENT</h1>
    <div class="content-container">
        <div id="payments-content" class="main-content">
            <div class="table-header">
                <form class="search-form" action="" method="POST">
                    <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

                    <x-select-input-property labelText="Search By" name="search-by">
                        <option value="payment-id" selected>Payment ID</option>
                        <option value="order-id">Order ID</option>
                    </x-select-input-property>

                    <button class="regular-button" onclick="">Search</button>
                </form>
                <a href="/payments/create"><button class="regular-button">Create</button></a>
            </div>
            <table class="search-table">
                <thead>
                <tr>
                    <th>PaymentID</th>
                    <th>OrderID</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody id="payments-tbody">
                @forelse($payments as $payment)
                    <tr onclick="">
                        <td>{{$payment->getPaymentId()}}</td>
                        <td>{{$payment->getOrder()->getOrderId()}}</td>
                        <td>{{$payment->getPaymentDate() == null ? "null" : $payment->getPaymentDate()->format("Y -m -d")}}</td>
                        <td>{{$payment->getAmount()}}</td>
                    </tr>
                @empty
                    <tr>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if(!empty($payments))
            <div id="payments-side-content" class="side-content">
                <h2>PAYMENT DETAILS</h2>
                <hr>
                <div class="side-content-scrollable">
                    <h3><b>Payment ID:</b><span>#</span></h3>
                    <p><b>Order ID:</b><span>#</span></p>
                    <p><b>Date:</b><span>#</span></p>
                    <p><b>Amount Payed:</b><span>#</span></p>
                    <p><b>Type:</b><span>#</span></p>
                    <p><b>Method:</b><span>#</span></p>
                </div>
                <a href="/payments/edit"><button class="regular-button" onclick="">Edit</button></a>
            </div>
        @endif
    </div>
</x-layout>
