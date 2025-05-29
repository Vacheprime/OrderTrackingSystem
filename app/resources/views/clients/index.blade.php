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
    @isset($messageHeader)
        <p id="{{$messageType}}" class="message-header">{{$messageHeader}}<button onclick="document.getElementById('{{$messageType}}').remove()">x</button></p>
    @endisset
    <div class="content-container">
        <div id="clients-content" class="main-content">
            <div class="table-content">
                <div class="table-header">
                    <form class="search-form" action="" method="GET">
                        <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>
                        <x-select-input-property labelText="Search By" name="search-by">
                            <option value="area" selected>Area</option>
                            <option value="first-name">First Name</option>
                            <option value="last-name">Last Name</option>
                            <option value="client-id">ClientID</option>
                        </x-select-input-property>
                    </form>
                    <button class="regular-button" onclick="refreshClientTable(1, true)">Search</button>
                </div>
                <div class="search-table-div">
                    <x-client-table :clients="$clients"/>
                </div>
            </div>
            <div class="search-table-pagination-div">
                <script>changeClientPage({{$page}}, {{$pages}});</script>
            </div>
        </div>
        @if(!empty($clients))
            <div id="clients-side-content" class="side-content">
                <div class="side-content-container">
                    <div class="side-content-header">
                        <h2>CLIENT DETAILS</h2>
                        <hr>
                        <h3><b>Client ID:</b><span id="detail-client-id">-</span></h3>
                    </div>
                    <div class="side-content-scrollable">
                        <p><b>First Name:</b><span id="detail-first-name">-</span></p>
                        <p><b>Last Name:</b><span id="detail-last-name">-</span></p>
                        <p><b>Reference Number:</b><span id="detail-reference-number">-</span></p>
                        <p><b>Phone Number:</b><span id="detail-phone-number">-</span></p>
                        <p><b>Street Name:</b><span id="detail-address-street">-</span></p>
                        <p><b>Apartment Number:</b><span id="detail-address-apt-num">-</span></p>
                        <p><b>Postal Code:</b><span id="detail-postal-code">-</span></p>
                        <p><b>Area (Neighborhood):</b><span id="detail-area">-</span></p>
                    </div>
                </div>
                <div class="side-content-details-options">
                    <a id="detail-edit-btn" {{-- HREF is ADDED Dynamically --}} class="regular-button">Edit</a>
                    <a id="detail-add-order-btn" {{-- HREF is ADDED Dynamically --}} class="regular-button">Add
                        Order</a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
