<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    /**
     * GET => '/'
     * Fetches the /resources/views/login/index.blade.php
     */
    public function login() {
        if (Auth::guard('employee')->check()) { //maybe change to user instead of employee
            return view("/home");
        }

        return view("login.index");
    }

    /**
     * POST => '/'
     * ["username", "password", "rememberLogin"]
     * Authenticates the login information
     */
    public function auth(Request $request) {
        $employee = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($employee)) {
            //session
            return redirect('/qr2fa');
        }

        return back()->withErrors([
            //message
        ]);
    }

    /**
     * POST => '/logout'
     * Logs out the user and destroy any cookies
     */
    public function logout() {
        return redirect('/');
    }

    /**
     * GET => '/qr2fa'
     * Fetches the /resources/views/login/qrverification.blade.php
     */
    public function qr2fa() {
        return view("login.qrverification");
    }

    /**
     * POST => '/qr2fa'
     * Verify if the qr code was scanned or not
     */
    public function authQR() {
        return redirect('/home');
    }

    /**
     * GET => '/code2fa'
     * Fetches the /resources/views/login/codeverification.blade.php
     */
    public function code2fa() {
        return view("login.codeverification");
    }

    /**
     * POST => '/code2fa'
     * ["verification-code"]
     * Verify the code with the 2FA Application
     */
    public function authCode(Request $request) {
        $validateData = $request->validate([
            "verification-code"=>"required|min:6"
        ]);
        return redirect("/newpassword");
    }

    /**
     * GET => '/contact'
     * Fetches the /resources/views/login/contactmethod.blade.php
     */
    public function contact() {
        return view("login.contactmethod");
    }

    /**
     * POST => '/contact'
     * ["contact-method-input"]
     * Checks if contacting method exists through Authenticator App
     */
    public function authContact(Request $request) {
        $validateData = $request->validate([
            "contact-method" => "required",
        ]);

        return redirect("/code2fa");
    }

    /**
     * GET => '/newpassword'
     * Fetches the /resources/views/login/newpassword.blade.php
     */
    public function newPassword() {
        return view("login.newpassword");
    }

    /**
     * POST => '/newpassword'
     * ["new-password-input", "confirm-password-input"]
     * Checks if new password and confirm password match & changes the user's passwords
     */
    public function authPassword(Request $request) {
        $validate = $request->validate([
            "new-password" => "required",
            "confirm-password" => "required",
        ]);
        return redirect("/");
    }
}