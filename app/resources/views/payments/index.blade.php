<link rel="stylesheet" href="{{ asset('css/payments.css') }}">

<x-layout title="Payment Management">
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <div class="table-header">
                <form class="table-header" action="" method="POST">
                    <input class="searchBar" type="text" placeholder="Search">

                    <select name="search-by" class="search-by-select">
                        <option value="" hidden selected>Search by</option>
                        <option value="paymentID">Payment ID</option>
                        <option value="orderID">Order ID</option>
                    </select>

                    <select name="filter-by" class="filter-by-select">
                        <option value="" hidden selected>Filter by</option>
                        <option value="filterNewest">Newest</option>
                        <option value="filterOldest">Oldest</option>
                        <option value="filterStatus">Status</option>
                    </select>

                    <button class="searchButton" onclick="">Search</button>
                </form>
                <a href="/payments/create"><button>Create</button></a>
            </div>
            <table>
                <thead>
                <tr>
                    <th>PaymentID</th>
                    <th>OrderID</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody id="orders-tbody">
                @forelse($payments as $payment)
                    <tr onclick="">
                        <th>$payment[0]</th>
                        <th>$payment[1]</th>
                        <th>$payment[2]</th>
                        <th>$payment[3]</th>
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
            <div id="orders-side-content" class="side-content">
                <div id="detailsOfSelectedRow">
                    <h2>Viewing Order Details</h2>
                    <div id="ID">
                        <p id="label">PAYMENT ID</p>
                        <p id="value"></p>
                    </div>
                    <div id="order">
                        <p id="label">Order</p>
                        <a href="/orders" id="value">View Order</a>
                    </div>
                    <div id="date">
                        <p id="label">Date</p>
                        <p id="value"></p>
                    </div>
                    <div id="amountPayed">
                        <p id="label">Amount payed</p>
                        <p id="value"></p>
                    </div>
                    <div id="type">
                        <p id="label">Type</p>
                        <p id="value"></p>
                    </div>
                    <div id="method">
                        <p id="label">Method</p>
                        <p id="value"></p>
                    </div>
                    <a href="/payments/edit"><button class="editButton" onclick="">Edit</button></a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
