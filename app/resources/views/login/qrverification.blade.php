<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout title="Verifying">
    <div id="login-content" class="main-content">
        <h1>2FA</h1>
        <p class="checkAuthenticator">Check Authenticator App</p>
        <img class="qrCode" src="QRCODE.png" alt="qrCode">
        <button class="qrExecuteButton" onclick="">Confirm</button>
        <a href="/home">Temp Confirm</a>
    </div>
</x-login-layout>
