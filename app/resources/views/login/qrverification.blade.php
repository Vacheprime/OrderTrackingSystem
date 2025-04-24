<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-layout title="Verifying">
    <div id="login-content" class="main-content">
        <h1>2FA</h1>
        <p id="checkAuthenticator">Check Authenticator App</p>
        <img class="qrCode" src="QRCODE.png" alt="qrCode">
        <a href="/home">temp confirm</a>
        <button class="executeButton" onclick="">Confirm</button>
    </div>
</x-layout>
