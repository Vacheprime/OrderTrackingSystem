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
                <form class="search-form" action="" method="POST">
                    <x-text-input-property labelText="Search" name="search-bar" :isLabel="false"/>

                    <x-select-input-property labelText="Search By" name="search-by">
                        <option value="client-id">Employee ID</option>
                        <option value="first-name">First Name</option>
                        <option value="last-name">Last Name</option>
                        <option value="last-name">Position</option>
                    </x-select-input-property>

                    <button class="regular-button" onclick="">Search</button>
                </form>
                <a href="/employees/create"><button class="regular-button">Create</button></a>
            </div>
            <table class="search-table">
                <thead>
                <tr>
                    <th>EmployeeID</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                </tr>
                </thead>
                <tbody id="employees-tbody">
                @forelse($employees as $employee)
                    <tr id="employee-id-{{$employee->getEmployeeId()}}" onclick="">
                        <td>{{$employee->getEmployeeId()}}</td>
                        <td>{{$employee->getFirstName()}}</td>
                        <td>{{$employee->getLastName()}}</td>
                        <td>{{$employee->getAccount()->getEmail()}}</td>
                        <td>{{$employee->getPhoneNumber()}}</td>
                    </tr>
                @empty
                    <tr>
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
        @if(!empty($employees))
            <div id="employees-side-content" class="side-content">
                <h2>EMPLOYEE DETAILS</h2>
                <hr>
                <div class="side-content-scrollable">
                    <h3><b>Employee ID:</b><span id="detail-employee-id">#</span></h3>
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
                <a href="/employees/{{$employee->getEmployeeId()}}/edit"><button class="regular-button" onclick="">Edit</button></a>
            </div>
        @endif
    </div>
</x-layout>
