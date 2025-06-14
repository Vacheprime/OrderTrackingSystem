<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\EnsureAdminSession;
use App\Http\Middleware\EnsureUser2FASetup;
use App\Http\Middleware\EnsureSessionExists;
use App\Http\Middleware\EnsureValidPasswordRequest;
use App\Http\Middleware\EnsureEmployeeSession;

// Route for base URL
Route::get('/', function () {
    if (session()->has('employee') && session()->get('employee')['2fa_setup']) {
        return redirect('/home');
    }
    return redirect('/login');
});

// ORDER TRACKING FOR CLIENTS
Route::get('/tracking', [TrackingController::class, "tracking"]);
Route::post('/tracking', [TrackingController::class, "track"]);
Route::get('/tracking/display', [TrackingController::class, "display"]);

// LOGINS
Route::get('/login', [LoginController::class, "login"]);
Route::post('/login', [LoginController::class, "auth"]);
Route::post('/logout', [LoginController::class, "logout"]);
Route::get('/logout', [LoginController::class, "logoutIndex"]);

Route::get('/qr2fa', [LoginController::class, "qr2fa"])->middleware(EnsureUser2FASetup::class);
Route::post('/qr2fa', [LoginController::class, "authQR"]);


Route::get('/code2fa', [LoginController::class, "code2fa"])->middleware(EnsureSessionExists::class);
Route::post('/code2fa', [LoginController::class, "authCode"])->middleware(EnsureSessionExists::class);

Route::get('/contact', [LoginController::class, "contact"]);
Route::post('/contact', [LoginController::class, "authContact"]);

Route::get('/newpassword', [LoginController::class, "newPassword"])->middleware(EnsureValidPasswordRequest::class);
Route::post('/newpassword', [LoginController::class, "authPassword"])->middleware(EnsureValidPasswordRequest::class);

// Account Specific
Route::get('/home', [HomeController::class, "index"])->middleware(EnsureEmployeeSession::class);

//Route::get('/settings', [UserController::class, "settings"]);

Route::get('/account', [AccountController::class, "index"])->middleware(EnsureEmployeeSession::class);
Route::put('/account', [AccountController::class, "update"])->middleware(EnsureEmployeeSession::class);

// Fabrication Plan Images
Route::get('/plans/{imageName}', [ImageController::class, 'show'])->middleware(EnsureEmployeeSession::class);

// CRUD Orders, Clients, Payments, Employees
Route::resource('orders', OrderController::class)->middleware(EnsureEmployeeSession::class);

Route::resource('clients', ClientController::class)->middleware(EnsureEmployeeSession::class);

Route::resource('payments', PaymentController::class)->middleware(EnsureEmployeeSession::class);

Route::resource('employees', EmployeeController::class)->middleware(EnsureAdminSession::class);

