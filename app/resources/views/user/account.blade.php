<link rel="stylesheet" href="{{ asset('css/account.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-layout title="Account">
    <h1 class="content-title">ACCOUNT</h1>
    @isset($messageHeader)
        <p id="{{$messageType}}" class="message-header">{{$messageHeader}}<button onclick="document.getElementById('{{$messageType}}').remove()">x</button></p>
    @endisset
    <div class="content-container">
        <div id="account-content" class="main-content">
            <div class="account-details">
                <form id="account-form" method="POST" action="/account" class="create-edit-form">
                @csrf
                @method('PUT')
                <div id="employee-information" class="details-div">
                    <h3>Employee Information</h3>
                    <x-text-input-property labelText="Initials" name="initials" :value="old('initials', $employee->getInitials())"/>
                    <x-text-input-property labelText="First name" name="first-name" :value="old('first-name', $employee->getFirstName())"/>
                    <x-text-input-property labelText="Last name" name="last-name" :value="old('last-name', $employee->getLastName())"/>
                    <x-text-input-property labelText="Phone number" name="phone-number" :value="old('phone-number', $employee->getPhoneNumber())"/>
                </div>
                <div id="address-information" class="details-div">
                    <h3>Address Information</h3>
                    <x-text-input-property labelText="Street" name="street" :value="old('street', $employee->getAddress()->getStreetName())"/>
                    <x-text-input-property labelText="Apartment Number" name="apartment-number" :value="old('apartment-number', $employee->getAddress()->getAppartmentNumber())"/>
                    <x-text-input-property labelText="Postal code" name="postal-code" :value="old('postal-code', $employee->getAddress()->getPostalCode())"/>
                    <x-text-input-property labelText="Area" name="area" :value="old('area', $employee->getAddress()->getArea())"/>
                </div>
                <div id="account-information" class="details-div">
                    <h3>Account Information</h3>
                    <x-text-input-property labelText="Email" name="email" :value="old('email', $employee->getAccount()->getEmail())"/>
                    <x-text-input-property labelText="New Password" name="password" type="password"/>
                    <x-text-input-property labelText="Confirm Password" name="confirm-password" type="password"/>
                </div>
                <p><i class="fa-solid fa-circle-info"></i> Leave the Password and Confirm Password fields empty if you do not wish to 
                    update the employee's password.</p>
                <div class="action-input-div">
                    <button type="submit" class="regular-button">Apply changes</button>
                </div>
            </form>  
            </div>   
        </div>
    </div>
</x-layout>
