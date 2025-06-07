<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<link rel="stylesheet" href="{{ asset('css/confirmation.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>
<script src="{{ asset('js/confirmation.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        initializeRowClickEvents(changePaymentDetails);
        highlightFirstRow(changePaymentDetails);
    });
</script>

<x-layout title="Payment Management">
    <h1 class="content-title">PAYMENT MANAGEMENT</h1>
    @isset($notificationMessage)
        <x-notification :message="$notificationMessage" :type="$messageType"/>
    @endisset
    <div class="content-container">
        <div id="payments-content" class="main-content">
            <div class="table-content">
                <div class="table-header">
                    <form class="search-form" action="" method="GET">
                        <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

                        <x-select-input-property labelText="Search By" name="search-by">
                            <option value="payment-id" selected>Payment ID</option>
                            <option value="order-id">Order ID</option>
                        </x-select-input-property>
                    </form>
                    <button class="regular-button" onclick="refreshPaymentTable({{$page}}, true)">Search</button>
                    <a href="/payments/create">
                        <button class="regular-button">Create</button>
                    </a>
                </div>
                <div class="search-table-div">
                    <x-payment-table :payments="$payments"/>
                </div>
            </div>
            <div class="search-table-pagination-div">
                <script>changePage(refreshPaymentTable, {{$page}}, {{$pages}});</script>
            </div>
        </div>
        @if(!empty($payments))
            <div id="payments-side-content" class="side-content">
                <div class="side-content-container">
                    <div class="side-content-header">
                        <h2>PAYMENT DETAILS</h2>
                        <hr>
                        <h3><b>Payment ID:</b><span id="detail-payment-id">-</span></h3>
                    </div>
                    <div class="side-content-scrollable">
                        <p><b>Order ID:</b><span id="detail-order-id">>-</span></p>
                        <p><b>Date:</b><span id="detail-payment-date">>-</span></p>
                        <p><b>Amount Payed:</b><span id="detail-amount">-</span></p>
                        <p><b>Type:</b><span id="detail-type">-</span></p>
                        <p><b>Method:</b><span id="detail-method">-</span></p>
                    </div>
                </div>
                <div class="side-content-details-options">
                    <a id="detail-edit-btn" {{-- HREF is ADDED Dynamically --}} class="regular-button">Edit</a>
                    @if(session()->has('employee') && session()->get('employee')['isEmployeeAdmin'])
                    <form id="detail-delete-form" method="POST" action="">
                        @csrf
                        @method("DELETE")
                        <button type="button" id="detail-delete-btn" class="regular-button" onclick="withConfirmation('Are you sure you want to delete the payment?', () => {
                            const form = document.getElementById('detail-delete-form');
                            form.submit();
                        })">Delete</button>
                    </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-layout>
