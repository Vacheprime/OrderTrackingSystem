<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-layout title="Edit Employee">
    <div class="layout-container">
        <div class="main-content">
            <a href="{{url()->previous()}}">
                <button class="regular-button">Go Back</button>
            </a>
            <h2>Edit Employee</h2>
            <hr/>
            <form action="{{route("employees.update", $employee->getEmployeeId())}}" method="POST">
                @csrf
                @method("PUT")
                <div class="flex-input-div">
                    <x-text-input-property labelText="Initials" name="initials" :value="$employee->getInitials()"/>
                    <x-text-input-property labelText="First Name" name="first-name" :value="$employee->getFirstName()"/>
                    <x-text-input-property labelText="Last Name" name="last-name" :value="$employee->getLastName()"/>
                    <x-text-input-property labelText="Email" name="email" :value="$employee->getAccount()->getEmail()"/>
                    <x-text-input-property labelText="Phone Number" name="phone-number"
                                           :value="$employee->getPhoneNumber()"/>
                    <x-text-input-property labelText="Address" name="address"
                                           :value="$employee->getAddress()->getStreetName()"/>
                    <x-text-input-property labelText="Position" name="position" :value="$employee->getPosition()"/>
                    <x-text-input-property labelText="Postal Code" name="postal-code"
                                           :value="$employee->getAddress()->getPostalCode()"/>
                    <x-text-input-property labelText="Area" name="area" :value="$employee->getAddress()->getArea()"/>
                    <x-select-input-property labelText="Account Status" name="account-status">
                        <option value="disabled" {{$employee->getAccount()->isAccountEnabled() ? "" : "selected"}}>
                            Disabled
                        </option>
                        <option value="enabled" {{$employee->getAccount()->isAccountEnabled() ? "selected" : ""}}>
                            Enabled
                        </option>
                    </x-select-input-property>
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
