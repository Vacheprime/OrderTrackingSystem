<link rel="stylesheet" href="{{ asset('css/account.css') }}">

<x-layout title="Account">
    <h1 class="content-title">ACCOUNT</h1>
    <div class="content-container">
        <div id="account-content" class="main-content">
            <div class="account-details">
                <form id="account-form" method="POST" action="/account" class="create-edit-form">
                @csrf
                @method('PUT')
                <div id="account-information" class="details-div">
                    <h3>Employee Information</h3>
                    <x-text-input-property labelText="First name" name="first-name" :value="$employee->getFirstName()"/>
                    <x-text-input-property labelText="Last name" name="last-name" :value="$employee->getLastName()"/>
                    <x-text-input-property labelText="Email" name="email" :value="$employee->getAccount()->getEmail()"/>
                    <x-text-input-property labelText="Phone number" name="phone-number" :value="$employee->getPhoneNumber()"/>
                </div>
                <div id="account-address" class="details-div">
                    <h3>Address Information</h3>
                    <x-text-input-property labelText="Street" name="street" :value="$employee->getAddress()->getStreetName()"/>
                    <x-text-input-property labelText="Apartment Number" name="apartment-number" :value="$employee->getAddress()->getAppartmentNumber()"/>
                    <x-text-input-property labelText="Postal code" name="postal-code" :value="$employee->getAddress()->getPostalCode()"/>
                    <x-text-input-property labelText="Area" name="area" :value="$employee->getAddress()->getArea()"/>
                </div>
                <div class="action-input-div">
                    <button type="submit" class="regular-button">Apply changes</button>
                </div>
            </form>  
            </div>   
        </div>
    </div>
</x-layout>
