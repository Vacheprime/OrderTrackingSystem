<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        initializeClientRowClickEvents();
        highlightClientFirstRow();
    });
</script>

<x-layout title="Client Management">
    <h1 class="content-title">CLIENT MANAGEMENT</h1>
    <div class="content-container">
        <div id="clients-content" class="main-content">
            <div class="table-header">
                <form class="search-form" action="" method="POST">
                    <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

                        <x-select-input-property labelText="Search By" name="search-by">
                            <option value="client-id" selected>Area</option>
                            <option value="first-name">First Name</option>
                            <option value="last-name">Last Name</option>
                            <option value="last-name">ClientID</option>
                        </x-select-input-property>

                    <button class="regular-button" onclick="">Search</button>
                </form>
                <a href="/clients/create"><button class="regular-button">Create</button></a>
            </div>
            <div class="search-table-div">
                <table class="search-table">
                    <thead>
                    <tr>
                        <th>ClientID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Client Reference #</th>
                        <th>Phone</th>
                        <th>Area</th>
                    </tr>
                    </thead>
                    <tbody id="orders-tbody">
                    @forelse($clients as $client)
                        <tr id="client-id-{{$client->getClientId()}}" onclick="">
                            <td>{{$client->getClientId()}}</td>
                            <td>{{$client->getFirstName()}}</td>
                            <td>{{$client->getLastName()}}</td>
                            <td>{{$client->getAddress()->getAddressId() . $client->getAddress()->getStreetName()}}</td>
                            <td>{{$client->getClientReference()}}</td>
                            <td>{{$client->getPhoneNumber()}}</td>
                            <td>{{$client->getAddress()->getArea()}}</td>
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
        </div>
        @if(!empty($client))
            <div id="clients-side-content" class="side-content">
                <h2>CLIENT DETAILS</h2>
                <hr>
                <div class="side-content-scrollable">
                    <h3><b>Client ID:</b><span id="detail-client-id">#</span></h3>
                    <p><b>First Name:</b><span id="detail-first-name">#</span></p>
                    <p><b>Last Name:</b><span id="detail-last-name">#</span></p>
                    <p><b>Reference Number:</b><span id="detail-reference-number">#</span></p>
                    <p><b>Phone Number:</b><span id="detail-phone-number">#</span></p>
                    <p><b>Address:</b><span id="detail-address">#</span></p>
                    <p><b>Postal Code:</b><span id="detail-postal-code">#</span></p>
                    <p><b>City:</b><span id="detail-city">#</span></p>
                    <p><b>Province:</b><span id="detail-province">#</span></p>
                    <p><b>Area (Neighborhood):</b><span id="detail-area">#</span></p>
                </div>
                <a href="/clients/{{$client->getClientId()}}/edit"><button class="regular-button" onclick="">Edit</button></a>
            </div>
        @endif
    </div>
</x-layout>
