<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout title="Contact Method">
    <div id="login-content" class="main-content">
        <h1>Enter Account Contact Information</h1>
        <form id="contact-input-form" action="/contact" method="POST">
            @csrf
            <x-text-input-property labelText="Enter Email or Phone Number" name="contact-method"/>
            <button type="submit" class="regular-button">Validate</button>
        </form>
    </div>
</x-login-layout>
