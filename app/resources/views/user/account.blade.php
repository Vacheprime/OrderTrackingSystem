<link rel="stylesheet" href="{{ asset('css/account.css') }}">

<x-layout>
    <h1 class="content-title">ACCOUNT</h1>
    <div class="content-container">

    <div id="account-content" class="main-content">
        <div id="account-header" class="account-div">
            <x-text-input-property labelText="First name" name="fname"/>
            <x-text-input-property labelText="Last name" name="lname"/>
            <x-text-input-property labelText="Email" name="email"/>
            <x-text-input-property labelText="Phone number" name="phonenumber"/>
            <x-text-input-property labelText="Address" name="address"/>
            <x-text-input-property labelText="Postal code" name="postalcode"/>
            <x-text-input-property labelText="City" name="city"/>
            <x-text-input-property labelText="Province" name="Province"/>
            <br />
            <x-text-input-property labelText="Password" name="password" readonly/>
            <button class="regular-button">Reset Password</button>
        </div>
        <button class="regular-button">Apply changes</button>
    </div>
    </div>
</x-layout>