<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-layout title="Edit Employee">
    <h1 class="content-title">EDIT EMPLOYEE</h1>
    <div class="content-container">
        <div id="employees-create-content" class="main-content">
            <div class="create-edit-header">
                <a href="/employees" class="regular-button">Go Back</a>
                <h2>Employee Information</h2>
                <div class="filler-div"></div>
            </div>
            <form action="{{route("employees.update", $employee->getEmployeeId())}}" method="POST" class="create-edit-form">
                @csrf
                @method("PUT")
                <div class="details-div">
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
