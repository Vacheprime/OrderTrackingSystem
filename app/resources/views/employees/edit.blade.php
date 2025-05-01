<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/employee.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('css/table.css') }}"> -->
 
<x-layout title="Edit Employee">
<div class="layout-container">
       <div class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>Edit Employee</h2>
            <hr/>
            <form action="/employee/store" method="POST">
                <div class="flex-input-div">
                    <x-text-input-property labelText="Initials" name="initials"/>
                    <x-text-input-property labelText="First Name" name="first-name"/>
                    <x-text-input-property labelText="Last Name" name="last-name"/>
                    <x-text-input-property labelText="Email" name="last-name"/>
                    <x-text-input-property labelText="Phone Number" name="phone-number"/>
                    <x-date-input-property labelText="Hired Date" name="hire-date" />
                    <x-text-input-property labelText="Address" name="address"/>
                    <x-text-input-property labelText="Postal Code" name="postal-code"/>
                    <x-text-input-property labelText="City" name="city"/>
                    <x-text-input-property labelText="Province" name="province"/>
                    <x-text-input-property labelText="Area (Neighborhood)" name="area"/>
                    <x-select-input-property name="account-status" labelText="Account Status">
                        <option value="disabled" selected>Disabled</option>
                        <option value="enabled">Enabled</option>
                    </x-select-input>
                </div>

                <div class="action-input-div">
                    <input class="regular-button" type="submit" value="Save"/>
                    <a href="/employees">
                        <button class="regular-button">Cancel</button>
                    </a>
               </div>
            </form>
        </div>
    </div>
</x-layout>
