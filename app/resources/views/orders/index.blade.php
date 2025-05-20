<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        initializeOrderRowClickEvents();
        highlightOrderFirstRow();
    });
</script>

<x-layout title="Order Management">
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    @isset($messageHeader)
        <p id="{{$messageType}}" class="message-header">{{$messageHeader}}<button onclick="document.getElementById('{{$messageType}}').remove()">x</button></p>
    @endisset
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <div class="table-content">
                <div class="table-header">
                    <form class="search-form" action="" method="GET">
                        <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

                        <x-select-input-property labelText="Search By" name="search-by">
                            <option value="order-id" selected>OrderID</option>
                            <option value="client-id">ClientID</option>
                            <option value="area">Area</option>
                            <option value="name">Name</option>
                        </x-select-input-property>

                        <x-select-input-property labelText="Order By" name="order-by">
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                            <option value="status" selected>Status</option>
                        </x-select-input-property>
                    </form>
                    <button class="regular-button" onclick="refreshOrderTable({{$page}}, true)">Search</button>
                    <a href="/orders/create?client=new" class="regular-button">Create</a>
                </div>
                <div class="search-table-div">
                    <x-order-table :orders="$orders"/>
                </div>
            </div>
            <div class="search-table-pagination-div">
                <script>changeOrderPage({{$page}}, {{$totalPages}});</script>
            </div>
        </div>
        @if(!empty($orders))
            <div id="orders-side-content" class="side-content">
                <div class="side-content-container">
                    <div class="side-content-header">
                        <h2>ORDER DETAILS</h2>
                        <hr>
                        <h3><b>ORDER ID:</b><span id="detail-order-id">-</span></h3>
                    </div>
                    <div class="side-content-scrollable">
                        <p><b>CLIENT ID:</b><span id="detail-client-id">-</span></p>
                        <p><b>Measured By:</b><span id="detail-measured-by">-</span></p>
                        <p><b>Reference Number:</b><span id="detail-reference-number">-</span></p>
                        <p><b>Invoice Number:</b><span id="detail-invoice-number">-</span></p>
                        <p><b>Total Price:</b><span id="detail-total-price">-</span></p>
                        <p><b>Status:</b><span id="detail-status">-</span></p>
                        <p><b>Fabrication Start Date:</b><span id="detail-fabrication-start-date">-</span></p>
                        <p><b>Installation Start Date:</b><span id="detail-installation-start-date">-</span></p>
                        <p><b>Completed Date:</b><span id="detail-pick-up-date">-</span></p>
                        <p><b>Material Name:</b><span id="detail-material-name">-</span></p>
                        <p><b>Slab Height:</b><span id="detail-slab-height">-</span></p>
                        <p><b>Slab Width:</b><span id="detail-slab-width">-</span></p>
                        <p><b>Slab Thickness:</b><span id="detail-slab-thickness">-</span></p>
                        <p><b>Slab Square Footage:</b><span id="detail-slab-square-footage">-</span></p>
                        <p><b>Sink Type:</b><span id="detail-sink-type">-</span></p>
                        <p><b>Fabrication Plan Image:</b><img src="" id="detail-fabrication-plan-image"/></p>
                        <p><b>Product Description:</b><x-area-input-property name="detail-product-description" labelText="Product Description" :isLabel="false"/></p>
                        <p><b>Product Notes:</b><x-area-input-property name="detail-product-notes" labelText="Product Notes" :isLabel="false"/></p>
                    </div>
                </div>
                <div class="side-content-details-options">
                    <a id="detail-edit-btn" {{-- HREF is ADDED Dynamically --}} class="regular-button"
                       onclick="">Edit</a>
                    <a id="detail-add-payment-btn" {{-- HREF is ADDED Dynamically --}} class="regular-button"
                       onclick="">Add Payment</a>
                       @if(session()->has('employee') && session()->get('employee')['isEmployeeAdmin'])

                       @endif
                </div>
            </div>
        @endif
    </div>
</x-layout>
