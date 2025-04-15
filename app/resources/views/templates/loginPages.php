<?php

namespace resources\views\templates;

class LoginPage
{

    function render()
    {
        echo '
    <div class="main-content">
    <h1 class="title">Login</h1>
    <form action="" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <a href="">Forgot Password?</a>
    <button type="submit" class="executeButton">Login</button>
    <label>
    <input type="checkbox" name="rememberLogin">
        Remember Login
    </label>
    </form>
    </div>
    ';
    }
}

class QrCodePage
{

    function render()
    {
        echo '
    <div class="main-content">
    <h1 class="title">2FA</h1>
    <p id="checkAuthenticator">Check Authenticator App<\p>
    <img class="qrCode" src="QRCODE.png" alt="qrCode">
    <button class="executeButton" onclick="">Confirm</button>
    </div>
    ';
    }
}
