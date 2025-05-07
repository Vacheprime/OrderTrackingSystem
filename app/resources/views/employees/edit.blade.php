<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-layout title="Edit Employee">
<div class="layout-container">
       <div class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>Edit Employee</h2>
            <hr/>
            <form action="{{route("employees.update", $employee->getEmployeeId())}}" method="POST">
                @csrf
                @method("PUT")
                <div class="flex-input-div">
                    <x-text-input-property labelText="Initials" name="initials"/>
                    <x-text-input-property labelText="First Name" name="first-name"/>
                    <x-text-input-property labelText="Last Name" name="last-name"/>
                    <x-text-input-property labelText="Email" name="email"/>
                    <x-text-input-property labelText="Phone Number" name="phone-number"/>
                    <x-text-input-property labelText="Address" name="address"/>
                    <x-date-input-property labelText="Hired Date" name="hire-date" />
                    <x-text-input-property labelText="Position" name="position"/>
                    <x-text-input-property labelText="Postal Code" name="postal-code"/>
                    <x-text-input-property labelText="City" name="city"/>
                    <x-text-input-property labelText="Province" name="province"/>
                    <div class="annoying-select">
                        <x-select-input-property labelText="Account Status" name="account-status">
                            <option value="disabled" selected>Disabled</option>
                            <option value="enabled">Enabled</option>
                        </x-select-input-property>
                    </div>
                </div>

                <div class="action-input-div">
                    <input class="regular-button" type="submit" value="Edit"/>
                    <a href="/employees">
                        <button class="regular-button">Cancel</button>
                    </a>
               </div>
            </form>
        </div>
    </div>
</x-layout>
