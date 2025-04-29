<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout title="Verifying">
    <div id="login-content" class="main-content">
        <h1>2FA</h1>
        <p id="enterVerification">Enter Verification Code</p>
        <input type="text" maxlength="6" class="inputForCode" placeholder="- - - - - -" />
        <a href="">Resend code?</a>
        <a href="/newpassword">temp verify</a>
        <button class="executeButton" onclick="">Verify</button>
    </div>
</x-login-layout>
