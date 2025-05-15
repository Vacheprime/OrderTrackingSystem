<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        initializePaymentRowClickEvents();
        highlightPaymentFirstRow();
    });
</script>

<x-layout title="Payment Management">
    <h1 class="content-title">PAYMENT MANAGEMENT</h1>
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
                    <button class="regular-button" onclick="refreshPaymentTable()">Search</button>
                    <a href="/payments/create">
                        <button class="regular-button">Create</button>
                    </a>
                </div>
                <div class="search-table-div">
                    <x-payment-table :payments="$payments"/>
                </div>
            </div>
            <div class="search-table-pagination-div">
                <script>changePaymentPage({{$page}}, {{$pages}});</script>
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
                </div>
            </div>
        @endif
    </div>
</x-layout>
