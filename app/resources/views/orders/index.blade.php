<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>

<x-layout>
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <div class="table-header">
                <form class="search-form" action="" method="POST">
                    <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

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
                        <tr onclick="selectRecord(this)">
                            <td>{{$order[0]}}</td>
                            <td>{{$order[1]}}</td>
                            <td>{{$order[2]}}</td>
                            <td>{{$order[3]}}</td>
                            <td>{{$order[4]}}</td>
                            <td>{{$order[5]}}</td>
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
                    <h3><b>ORDER ID:</b><span>#</span></h3>
                    <p><b>CLIENT ID:</b><span>#</span></p>
                    <p><b>Measured By:</b><span>#</span></p>
                    <p><b>Reference Number:</b><span>#</span></p>
                    <p><b>Invoice Number:</b><span>#</span></p>
                    <p><b>Total Price:</b><span>#</span></p>
                    <p><b>Status:</b><span>#</span></p>
                    <p><b>Fabrication Start Date:</b><span>#</span></p>
                    <p><b>Installation Start Date:</b><span>#</span></p>
                    <p><b>Pick Up Date:</b><span>#</span></p>
                    <p><b>Material Name:</b><span>#</span></p>
                    <p><b>Slab Height:</b><span>#</span></p>
                    <p><b>Slab Width:</b><span>#</span></p>
                    <p><b>Slab Thickness:</b><span>#</span></p>
                    <p><b>Slab Square Footage:</b><span>#</span></p>
                    <p><b>Sink Type:</b><span>#</span></p>
                    <p><b>Fabrication Plan Image:</b><img src="" alt=""/></p>
                    <p><b>Product Description:</b><textarea placeholder="Product Description"></textarea></p>
                    <p><b>Product Notes:</b><textarea placeholder="Product Notes"></textarea></p>
                </div>
                <a href="/orders/edit"><button class="regular-button" onclick="">Edit</button></a>
            </div>
        @endif
    </div>
</x-layout>
