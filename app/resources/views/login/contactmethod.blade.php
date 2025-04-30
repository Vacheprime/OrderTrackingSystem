<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-layout title="Contact Method">
    <div id="login-content" class="main-content">
        <h1>Enter Confirmation Contact</h1>
        <form action="" method="POST">
            <x-text-input-property labelText="Enter Email or Phone Number" name="contact-method"/>
            <button class="executeButton" onclick="">Check existence</button>
        </form>
        <a href="/code2fa">Temp Confirm</a>
    </div>
</x-layout>
