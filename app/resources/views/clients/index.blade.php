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
                <form class="search-form" action="" method="GET">
                    <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

                        <x-select-input-property labelText="Search By" name="search-by">
                            <option value="client-id" selected>Area</option>
                            <option value="first-name">First Name</option>
                            <option value="last-name">Last Name</option>
                            <option value="last-name">ClientID</option>
                        </x-select-input-property>
                </form>
                <button class="regular-button" onclick="refreshClientTable()">Search</button>
                <a href="/clients/create"><button class="regular-button">Create</button></a>
            </div>
            <div class="search-table-div">
                <x-client-table :clients="$clients"/>
            </div>
        </div>
        @if(!empty($clients))
            <div id="clients-side-content" class="side-content">
                <div id="side-content-header">
                    <h2>CLIENT DETAILS</h2>
                    <hr>
                    <h3><b>Client ID:</b><span id="detail-client-id">#</span></h3>
                </div>
                <div class="side-content-scrollable">
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
                <div id="side-content-details-options">
                    <a id="detail-edit-btn" {{-- HREF is ADDED Dynamically --}}><button class="regular-button" onclick="">Edit</button></a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
