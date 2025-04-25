<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout>
    <div id="login-content" class="main-content">
        <h1>Login</h1>
        <form class="login-form" action="" method="POST">
            <x-text-input-property labelText="Username" name="username"/>
            <x-text-input-property labelText="Password" name="password" :password="true"/>
            <a href="/contactmethod">Forgot Password?</a>
            <a href="/qr2fa">temporary login</a>
            <button type="submit" class="regular-button">Login</button>
            <div>
                <input type="checkbox" name="rememberLogin">
                <label>
                    Remember Login
                </label>
            </div>
        </form>
    </div>
</x-login-layout>
