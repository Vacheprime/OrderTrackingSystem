<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout title="Contact Method">
    <div id="login-content" class="main-content">
        <h1>Enter Confirmation Contact</h1>
        <form action="" method="POST">
            <x-text-input-property labelText="Enter Email or Phone Number" name="contact-method"/>
            <button class="executeButton" onclick="">Confirm</button>
        </form>
        <a href="/code2fa">temp confirm</a>
    </div>
</x-login-layout>
