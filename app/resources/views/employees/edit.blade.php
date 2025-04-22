<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<x-layout title="Edit Employee">
    <div class="content-container">
        <div id="employees-content" class="main-content">
            <a href="{{url()->previous()}}"><button>Go Back</button></a>
            <h2>Edit Employee</h2>
            <hr/>
            <form action="/clients/update" method="POST">
                <div class="flex-input-div">
                    <x-text-input-property property="Initials" propertyName="initials"/>
                    <x-text-input-property property="First Name" propertyName="first-name"/>
                    <x-text-input-property property="Last Name" propertyName="last-name"/>
                    <x-text-input-property property="Email" propertyName="last-name"/>
                    <x-text-input-property property="Phone Number" propertyName="phone-number"/>
                    <label for="hire-date-input">Hired Date</label>
                    <input type="date" name="hire-date-input" id="hire-date-input">
                    <x-text-input-property property="Address" propertyName="address"/>
                    <x-text-input-property property="Postal Code" propertyName="postal-code"/>
                    <x-text-input-property property="City" propertyName="city"/>
                    <x-text-input-property property="Province" propertyName="province"/>
                    <x-text-input-property property="Area (Neighborhood)" propertyName="area"/>
                    <label for="account-status-select">Account Status</label>
                    <select name="account-status-select" id="account-status-select" class="regular-select">
                        <option value="disabled" selected>Disabled</option>
                        <option value="enabled">Enabled</option>
                    </select>
                </div>
                <input class="regular-button" value="Create"/>
            </form>
            <a href="/employees">
                <button class="regular-button">Cancel</button>
            </a>
        </div>
    </div>
</x-layout>
