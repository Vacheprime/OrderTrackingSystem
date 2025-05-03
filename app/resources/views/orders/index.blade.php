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
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <div class="table-header">
                <form class="search-form" action="" method="POST">
                    <x-text-input-property labelText="Search" name="search-bar" :isLabel="false" />

                    <x-select-input-property labelText="Search By" name="search-by">
                        <option value="order-id" selected>OrderID</option>
                        <option value="client-id">ClientID</option>
                        <option value="area">Area</option>
                        <option value="name">Name</option>
                    </x-select-input-property>

                    <x-select-input-property labelText="Filter By" name="filter-by">
                        <option value="newest" selected>Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="status">Status</option>
                    </x-select-input-property>

                    <button class="regular-button" onclick="">Search</button>
                </form>
                <a href="/orders/create"><button class="regular-button">Create</button></a>
            </div>
            <table class="search-table">
                <thead>
                    <tr>
                        <th>OrderID</th>
                        <th>ClientID</th>
                        <th>Reference Number</th>
                        <th>Measured by</th>
                        <th>Fabrication start date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="orders-tbody">
                    @forelse($orders as $order)
                    <tr id="order-id-{{$order->getOrderId()}}" onclick="">
                        <td>{{$order->getOrderId()}}</td>
{{--                        <td>{{$order->getInvoiceNumber() == null ? "null" : "null"}}</td>--}}
                        <td>{{$order->getClient()->getClientId()}}</td>
                        <td>{{$order->getReferenceNumber()}}</td>
                        <td>{{$order->getMeasuredBy()->getInitials()}}</td>
                        <td>{{$order->getFabricationStartDate() == null ? "null" : $order->getFabricationStartDate()->format("Y -m -d")}}</td>
                        <td class="status {{ strtolower($order->getStatus()->value) }}">
                            {{$order->getStatus()->value}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(!empty($orders))
            <div id="orders-side-content" class="side-content">
                <h2>ORDER DETAILS</h2>
                <hr>
                <div class="side-content-scrollable">
                    <h3><b>ORDER ID:</b><span id="detail-order-id">#</span></h3>
                    <p><b>CLIENT ID:</b><span id="detail-client-id">#</span></p>
                    <p><b>Measured By:</b><span id="detail-measured-by">#</span></p>
                    <p><b>Reference Number:</b><span id="detail-reference-number">#</span></p>
                    <p><b>Invoice Number:</b><span id="detail-invoice-number">#</span></p>
                    <p><b>Total Price:</b><span id="detail-total-price">#</span></p>
                    <p><b>Status:</b><span id="detail-status">#</span></p>
                    <p><b>Fabrication Start Date:</b><span id="detail-fabrication-start-date">#</span></p>
                    <p><b>Installation Start Date:</b><span id="detail-installation-start-date">#</span></p>
                    <p><b>Pick Up Date:</b><span id="detail-pick-up-date">#</span></p>
                    <p><b>Material Name:</b><span id="detail-material-name">#</span></p>
                    <p><b>Slab Height:</b><span id="detail-slab-height">#</span></p>
                    <p><b>Slab Width:</b><span id="detail-slab-width">#</span></p>
                    <p><b>Slab Thickness:</b><span id="detail-slab-thickness">#</span></p>
                    <p><b>Slab Square Footage:</b><span id="detail-slab-square-footage">#</span></p>
                    <p><b>Sink Type:</b><span id="detail-sink-type">#</span ></p>
                    <p><b>Fabrication Plan Image:</b><img src="" id="detail-fabrication-plan-image"/></p>
                    <p><b>Product Description:</b><textarea placeholder="Product Description" id="detail-product-description"></textarea></p>
                    <p><b>Product Notes:</b><textarea placeholder="Product Notes" id="detail-product-notes"></textarea></p>
                </div>
                <a href="/orders/{{$order->getOrderId()}}/edit"><button class="regular-button" onclick="">Edit</button></a>
            </div>
        @endif
    </div>
</x-layout>
