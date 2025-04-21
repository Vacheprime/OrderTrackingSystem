<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout>
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <div class="table-header">
                <form class="table-header" action="" method="POST">
                    <input class="searchBar" type="text" placeholder="Search">

                    <select name="search-by" class="search-by-select">
                        <option value="" hidden selected>Search by</option>
                        <option value="searchArea">Area</option>
                        <option value="searchName">Name</option>
                        <option value="searchOrderID">OrderID</option>
                        <option value="searchClientID">ClientID</option>
                    </select>

                    <select name="filter-by" class="filter-by-select">
                        <option value="" hidden selected>Filter by</option>
                        <option value="filterNewest">Newest</option>
                        <option value="filterOldest">Oldest</option>
                        <option value="filterStatus">Status</option>
                    </select>

                    <button class="searchButton" onclick="">Search</button>
                </form>
                <a href="/orders/create"><button>Create</button></a>
            </div>
            <table>
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
                        <tr onclick="">
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
                <div id="detailsOfSelectedRow">
                    <h2>Viewing Order Details</h2>
                    <div id="ID">
                        <p id="label">ORDER ID</p>
                        <p id="value"></p>
                    </div>
                    <div id="client">
                        <p id="label">Client</p>
                        <a href=""></a>
                    </div>
                    <div id="measuredBy">
                        <p id="label">Measured by</p>
                        <p id="value"></p>
                    </div>
                    <div id="referenceNumber">
                        <p id="label">Reference number</p>
                        <p id="value"></p>
                    </div>
                    <div id="invoiceNumber">
                        <p id="label">Invoice number</p>
                        <p id="value"></p>
                    </div>
                    <div id="totalPrice">
                        <p id="label">Total price</p>
                        <p id="value"></p>
                    </div>
                    <div id="status">
                        <p id="label">Status</p>
                        <select class="statusDropdown">
                            <option value="" disabled selected>Choose</option>
                            <option value="confirmedMsNotReady">Confirmed ms not ready</option>
                            <option value="confirmedMsReady">Confirmed ms ready</option>
                            <option value="readyForMs">Ready for ms</option>
                            <option value="pickedUp">Picked up</option>
                            <option value="installed">Installed</option>
                        </select>
                    </div>
                    <div id="fabrication_startDate">
                        <p id="label">Fabrication_start date</p>
                        <p id="value"></p>
                    </div>
                    <div id="installationDate">
                        <p id="label">Installation date</p>
                        <p id="value"></p>
                    </div>
                    <div id="picked_upDate">
                        <p id="label">Picked_up date</p>
                        <p id="value"></p>
                    </div>
                    <div id="materialName">
                        <p id="label">Material name</p>
                        <p id="value"></p>
                    </div>
                    <div id="slabHeight">
                        <p id="label">Slab height</p>
                        <p id="value"></p>
                    </div>
                    <div id="slabWidth">
                        <p id="label">Slab width</p>
                        <p id="value"></p>
                    </div>
                    <div id="slabThickness">
                        <p id="label">Slab thickness</p>
                        <p id="value"></p>
                    </div>
                    <div id="slabSquareFootage">
                        <p id="label">Slab square footage</p>
                        <p id="value"></p>
                    </div>
                    <div id="sinkType">
                        <p id="label">Sink type</p>
                        <p id="value"></p>
                    </div>
                    <div id="fabrication_plan image">
                        <p id="label"></p>
                        <div class="fabPlanImage">
                            <img class="fabricationPlanImage" src="" alt="fabricationPlanImage">
                        </div>
                    </div>
                    <div id="productDescription">
                        <p id="label">Product description</p>
                        <p id="value"></p>
                    </div>
                    <div id="productNotes">
                        <p id="label">Product notes</p>
                        <p id="value"></p>
                    </div>
                    <a href="/orders/edit"><button class="editButton" onclick="">Edit</button></a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
