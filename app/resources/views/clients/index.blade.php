<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<x-layout title="Client Management">
    <h1 class="content-title">CLIENT MANAGEMENT</h1>
    <div class="content-container">
        <div id="clients-content" class="main-content">
            <div class="table-header">
                <form class="search-form" action="" method="POST">
                    <input class="search-bar" type="text" placeholder="Search">

                    <select name="search-by" class="search-by-select">
                        <option value="" hidden selected>Search by</option>
                        <option value="client-id">Client ID</option>
                        <option value="first-name">First Name</option>
                        <option value="last-name">Last Name</option>
                    </select>

                    <select name="filter-by" class="filter-by-select">
                        <option value="" hidden selected>Filter by</option>
                        <option value="filter-newest">Newest</option>
                        <option value="filter-oldest">Oldest</option>
                        <option value="filter-status">Status</option>
                    </select>

                    <button class="regular-button" onclick="">Search</button>
                </form>
                <a href="/payments/create"><button class="regular-button">Create</button></a>
            </div>
            <table class="search-table">
                <thead>
                <tr>
                    <th>ClientID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Reference Number</th>
                    <th>Phone Number</th>
                    <th>Area</th>
                </tr>
                </thead>
                <tbody id="orders-tbody">
                @forelse($clients as $client)
                    <tr onclick="">
                        <td>{{$client[0]}}</td>
                        <td>{{$client[1]}}</td>
                        <td>{{$client[2]}}</td>
                        <td>{{$client[3]}}</td>
                        <td>{{$client[4]}}</td>
                        <td>{{$client[5]}}</td>
                        <td>{{$client[6]}}</td>
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
        @if(!empty($client))
            <div id="clients-side-content" class="side-content">
                <h2>CLIENT DETAILS</h2>
                <hr>
                <div class="side-content-scrollable">
                    <h3><b>First Name:</b><span>#</span></h3>
                    <p><b>Last Name:</b><span>#</span></p>
                    <p><b>Reference Number:</b><span>#</span></p>
                    <p><b>Phone Number:</b><span>#</span></p>
                    <p><b>Address:</b><span>#</span></p>
                    <p><b>Postal Code:</b><span>#</span></p>
                    <p><b>City:</b><span>#</span></p>
                    <p><b>Province:</b><span>#</span></p>
                    <p><b>Area (Neighborhood):</b><span>#</span></p>
                </div>
                <a href="/payments/edit"><button class="regular-button" onclick="">Edit</button></a>
            </div>
        @endif
    </div>
</x-layout>
