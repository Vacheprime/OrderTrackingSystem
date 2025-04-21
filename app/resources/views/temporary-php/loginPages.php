<?php


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
    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
    <div class="main-content">
    <h1 class="title">2FA</h1>
    <p id="checkAuthenticator">Check Authenticator App<\p>
    <img class="qrCode" src="QRCODE.png" alt="qrCode">
    <button class="executeButton" onclick="">Confirm</button>
    </div>
    ';
    }
}

class VerificationCodePage
{

    function render()
    {
        echo '
    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
    <div class="main-content">
    <h1 class="title">2FA</h1>
    <p id="enterVerification">Enter Verification Code<\p>
    <input type="text" maxlength="6" class="inputForCode" placeholder="- - - - - -" />
    <a  href="">Resend code?</a>
    <button class="executeButton" onclick="">Verify</button>
    </div>
    ';
    }
}

class ResetPasswordPage
{

    function render()
    {
        echo '
    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
    <div class="main-content">
    <h1 class="title">Enter New Password</h1>
    <form action="" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <button class="executeButton" onclick="">Confirm</button>
    </form>
    </div>
    ';
    }
}
