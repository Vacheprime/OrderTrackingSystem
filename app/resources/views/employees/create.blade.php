<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-layout title="Create Employee">
    <h1 class="content-title">CREATING EMPLOYEE</h1>
    <div class="content-container">
        <div id="employees-create-content" class="main-content">
            <div class="create-edit-header">
                <a href="/employees" class="regular-button">Go Back</a>
                <h2>Employee Information</h2>
                <div class="filler-div"></div>
            </div>
            <form action="/employees" method="POST" class="create-edit-form">
                @csrf
                <h3>Employee Details</h3>
                <div id="employee-details-div" class="details-div">
                    <x-text-input-property labelText="Initials" name="initials" :value="old('initials')"/>
                    <x-text-input-property labelText="First Name" name="first-name" :value="old('first-name')"/>
                    <x-text-input-property labelText="Last Name" name="last-name" :value="old('last-name')"/>
                    
                    <x-text-input-property labelText="Phone Number" name="phone-number" :value="old('phone-number')"/>
                    <x-text-input-property labelText="Position" name="position" :value="old('position')"/>
                </div>
                <h3>Address Details</h3>
                <div id="address-details-div" class="details-div">
                    <x-text-input-property labelText="Street Name" name="address-street" :value="old('address-street')"/>
                    <x-text-input-property labelText="Apartment Number" name="address-apt-num" :value="old('address-apt-num')"/>
                    <x-text-input-property labelText="Postal Code" name="postal-code" :value="old('postal-code')"/>
                    <x-text-input-property labelText="Area" name="area" :value="old('area')"/>
                </div>
                <h3>Account Details</h3>
                <div id="account-details-div" class="details-div">
                    <x-text-input-property labelText="Email" name="email" :value="old('email')"/>
                    <x-text-input-property labelText="Password" name="password" :password="true"/>
                    <x-text-input-property labelText="Confirm Password" name="confirm-password" :password="true"/>
                </div>
                <p><i class="fa-solid fa-circle-info"></i> Please note that created employee accounts are disabled by
                    default.</p>
                <div class="action-input-div">
                    <button class="regular-button" type="submit">Create</button>
                    <a href="/employees" class="regular-button">Cancel</a>
                </div>
            </form>


        </div>
    </div>
</x-layout>
