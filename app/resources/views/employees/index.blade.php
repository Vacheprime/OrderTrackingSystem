<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

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
                    <tr onclick="">
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
                    <h3><b>Employee ID:</b><span>#</span></h3>
                    <p><b>Initials:</b><span>#</span></p>
                    <p><b>First Name:</b><span>#</span></p>
                    <p><b>Last Name:</b><span>#</span></p>
                    <p><b>Hired Date:</b><span>#</span></p>
                    <p><b>Position:</b><span>#</span></p>
                    <p><b>Email:</b><span>#</span></p>
                    <p><b>Phone Number:</b><span>#</span></p>
                    <p><b>Address:</b><span>#</span></p>
                    <p><b>Postal Code:</b><span>#</span></p>
                    <p><b>City:</b><span>#</span></p>
                    <p><b>Province:</b><span>#</span></p>
                    <p><b>Account Status:</b><span>#</span></p>
                </div>
                <a href="/employees/edit"><button class="regular-button" onclick="">Edit</button></a>
            </div>
        @endif
    </div>
</x-layout>
