<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="{{ asset('css/confirmation.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="{{ asset('js/confirmation.js') }}"></script>

<x-layout title="Edit Employee">
    <h1 class="content-title">EDIT EMPLOYEE</h1>
    <div class="content-container">
        <div id="employees-create-content" class="main-content">
            <div class="create-edit-header">
                <a href="/employees" class="regular-button">Go Back</a>
                <h2>Employee Information</h2>
                <div class="filler-div"></div>
            </div>
            <form id="employee-edit-form" action="{{route("employees.update", $employee->getEmployeeId())}}" method="POST" class="create-edit-form">
                @csrf
                @method("PUT")
                <h3>Employee Details</h3>
                <div id="employee-details-div" class="details-div">
                    <x-text-input-property labelText="Initials" name="initials" :value="old('initials', $employee->getInitials())"/>
                    <x-text-input-property labelText="First Name" name="first-name" :value="old('first-name', $employee->getFirstName())"/>
                    <x-text-input-property labelText="Last Name" name="last-name" :value="old('last-name', $employee->getLastName())"/>
                    <x-text-input-property labelText="Phone Number" name="phone-number" :value="old('phone-number', $employee->getPhoneNumber())"/>
                    <x-text-input-property labelText="Position" name="position" :value="old('position', $employee->getPosition())"/>


                    <x-select-input-property labelText="Account Status" name="account-status" :disabled="$employee->getEmployeeId() == $currentEmployeeId">
                        <option value="disabled" {{$employee->getAccount()->isAccountEnabled() ? "" : "selected"}}>
                            Disabled
                        </option>
                        <option value="enabled" {{$employee->getAccount()->isAccountEnabled() ? "selected" : ""}}>
                            Enabled
                        </option>
                    </x-select-input-property>
                    <x-select-input-property labelText="Admin" name="admin-status" :disabled="$employee->getEmployeeId() == $currentEmployeeId">
                        <option value="disabled" {{$employee->getAccount()->isAdmin() ? "" : "selected"}}>
                            Disabled
                        </option>
                        <option value="enabled" {{$employee->getAccount()->isAdmin() ? "selected" : ""}}>
                            Enabled
                        </option>
                    </x-select-input-property>

                    {{-- Add hidden forms for submitting the values for admin status and account status if those are disabled --}}
                    @if($employee->getEmployeeId() == $currentEmployeeId)
                        <input type="hidden" name="admin-status-select" value="{{$employee->getAccount()->isAdmin() ? 'enabled' : 'disabled'}}">
                        <input type="hidden" name="account-status-select" value="{{$employee->getAccount()->isAccountEnabled() ? 'enabled' : 'disabled'}}">
                    @endif
                </div>
                <h3>Address Details</h3>
                <div id="address-details-div" class="details-div">
                    <x-text-input-property labelText="Street Name" name="address-street"
                                           :value="old('address-street', $employee->getAddress()->getStreetName())"/>
                    <x-text-input-property labelText="Apartment Number" name="address-apt-num"
                                           :value="old('address-apt-num', $employee->getAddress()->getAppartmentNumber())"/>
                    <x-text-input-property labelText="Postal Code" name="postal-code"
                                           :value="old('postal-code', $employee->getAddress()->getPostalCode())"/>
                    <x-text-input-property labelText="Area (Neighborhood)" name="area" :value="old('area', $employee->getAddress()->getArea())"/>

                </div>
                <h3>Account Details</h3>
                <div id="account-details-div" class="details-div">
                    <x-text-input-property labelText="Email" name="email" :value="old('email', $employee->getAccount()->getEmail())"/>
                    <x-text-input-property labelText="Password" name="password" password="true"/>
                    <x-text-input-property labelText="Confirm Password" name="confirm-password" password="true"/>
                </div>
                <p><i class="fa-solid fa-circle-info"></i> Leave the Password and Confirm Password fields empty if you do not wish to 
                    update the employee's password.</p>
                <div class="action-input-div">
                    <button class="regular-button" type="button" onclick="withConfirmation('Confirm changes to this employee?', () => {
                        document.getElementById('employee-edit-form').submit();
                    })">Save</button>
                    <a href="/employees" class="regular-button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
