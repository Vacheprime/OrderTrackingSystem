<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout title="Login">
    <div id="login-content" class="main-content">
        <h1>Login</h1>
        <form class="login-form" action="/" method="POST">
            @csrf
            <x-text-input-property labelText="Username" name="username"/>
            <x-text-input-property labelText="Password" name="password" :password="true"/>
            <a href="/contact">Forgot Password?</a>
            <button type="submit" class="regular-button">Login</button>
            <div>
                <input type="checkbox" id="remember-login" name="remember-login-input">
                <label for="remember-login">Remember Login</label>
            </div>
        </form>
    </div>
</x-login-layout>
