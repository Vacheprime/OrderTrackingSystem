<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="{{ asset('js/tables.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        initializeEmployeeRowClickEvents();
        highlightEmployeeFirstRow();
    });
</script>

<x-layout title="Employee Management">
    <h1 class="content-title">EMPLOYEE MANAGEMENT</h1>
    <div class="content-container">
        <div id="employees-content" class="main-content">
            <div class="table-header">
                <form class="search-form" action="" method="GET">
                    <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

                    <x-select-input-property labelText="Search By" name="search-by">
                        <option value="client-id">Employee ID</option>
                        <option value="first-name">First Name</option>
                        <option value="last-name">Last Name</option>
                        <option value="last-name">Position</option>
                    </x-select-input-property>


                </form>
                <button class="regular-button" onclick="refreshEmployeeTable()">Search</button>
                <a href="/employees/create"><button class="regular-button">Create</button></a>
            </div>
            <div class="search-table-div">
                <x-employee-table :employees="$employees"/>
            </div>
        </div>
        @if(!empty($employees))
            <div id="employees-side-content" class="side-content">
                <div id="side-content-header">
                    <h2>EMPLOYEE DETAILS</h2>
                    <hr>
                    <h3><b>Employee ID:</b><span id="detail-employee-id">#</span></h3>
                </div>
                <div class="side-content-scrollable">
                    <p><b>Initials:</b><span id="detail-initials">#</span></p>
                    <p><b>First Name:</b><span id="detail-first-name">#</span></p>
                    <p><b>Last Name:</b><span id="detail-last-name">#</span></p>
                    <p><b>Hired Date:</b><span id="detail-hired-date">#</span></p>
                    <p><b>Position:</b><span id="detail-position">#</span></p>
                    <p><b>Email:</b><span id="detail-email">#</span></p>
                    <p><b>Phone Number:</b><span id="detail-phone-number">#</span></p>
                    <p><b>Address:</b><span id="detail-address">#</span></p>
                    <p><b>Postal Code:</b><span id="detail-postal-code">#</span></p>
                    <p><b>City:</b><span id="detail-city">#</span></p>
                    <p><b>Province:</b><span id="detail-province">#</span></p>
                    <p><b>Account Status:</b><span id="detail-account-status">#</span></p>
                </div>
                <div id="side-content-details-options">
                    <a id="detail-edit-btn" {{-- HREF is ADDED Dynamically --}}><button class="regular-button" onclick="">Edit</button></a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
