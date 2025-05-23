<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout title="Resetting Password">
    <div id="login-content" class="main-content">
        <h1>Enter New Password</h1>
        <form class="login-form" action="/newpassword" method="POST">
            @csrf
            <x-text-input-property labelText="New Password" name="new-password" :password="true"/>
            <x-text-input-property labelText="Confirm Password" name="confirm-password" :password="true"/>
            <button class="regular-button" type="submit">Confirm</button>
        </form>
    </div>
</x-login-layout>
