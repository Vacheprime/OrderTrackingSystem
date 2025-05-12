<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout title="Verifying">
    <div id="login-content" class="main-content">
        <h1>2FA</h1>
        <p class="checkAuthenticator">Check Authenticator App</p>
        <form id="qr-code-form" action="/qr2fa" method="POST">
            @csrf
            <img class="qrCode" src="QRCODE.png" alt="qrCode">
            <button class="regular-button" type="submit">Confirm</button>
        </form>
    </div>
</x-login-layout>
