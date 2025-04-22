<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-layout>
    <div id="login-content" class="main-content">
        <h1>Login</h1>
        <form class="login-form" action="" method="POST">
            <x-text-input-property property="Username" propertyName="username"/>
            <x-text-input-property property="Password" propertyName="password" :password="true"/>
            <a href="/contactmethod">Forgot Password?</a>
            <a href="/qr2fa">temporary login</a>
            <button type="submit" class="executeButton">Login</button>
            <div>
                <input type="checkbox" name="rememberLogin">
                <label>
                    Remember Login
                </label>
            </div>
        </form>
    </div>
</x-layout>
