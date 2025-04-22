<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<x-layout title="Client Management">
    <h1 class="content-title">CLIENT MANAGEMENT</h1>
    <div class="content-container">
        <div id="clients-content" class="main-content">
            <div class="table-header">
                <form class="search-form" action="" method="POST">
                    <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

                    <x-select-input-property labelText="Search By" name="search-by">
                        <option value="client-id" selected>Client ID</option>
                        <option value="first-name">First Name</option>
                        <option value="last-name">Last Name</option>
                    </x-select-input-property>

                    <x-select-input-property labelText="Filter By" name="filter-by">
                        <option value="newest" selected>Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="status">Status</option>
                    </x-select-input-property>

                    <button class="regular-button" onclick="">Search</button>
                </form>
                <a href="/clients/create"><button class="regular-button">Create</button></a>
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
                    <h3><b>Client ID:</b><span>#</span></h3>
                    <p><b>First Name:</b><span>#</span></p>
                    <p><b>Last Name:</b><span>#</span></p>
                    <p><b>Reference Number:</b><span>#</span></p>
                    <p><b>Phone Number:</b><span>#</span></p>
                    <p><b>Address:</b><span>#</span></p>
                    <p><b>Postal Code:</b><span>#</span></p>
                    <p><b>City:</b><span>#</span></p>
                    <p><b>Province:</b><span>#</span></p>
                    <p><b>Area (Neighborhood):</b><span>#</span></p>
                </div>
                <a href="/clients/edit"><button class="regular-button" onclick="">Edit</button></a>
            </div>
        @endif
    </div>
</x-layout>
