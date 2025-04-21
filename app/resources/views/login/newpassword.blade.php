<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-layout title="Resetting Password">
    <div id="login-content" class="main-content">
        <h1>Enter New Password</h1>
        <form action="" method="POST">
            <x-input-property property="New Password" propertyName="new-password" :password="true"/>
            <x-input-property property="Confirm Password" propertyName="confirm-password" :password="true"/>
            <button class="executeButton" onclick="">Confirm</button>
        </form>
        <a href="/">temp confirm</a>
    </div>
</x-layout>
