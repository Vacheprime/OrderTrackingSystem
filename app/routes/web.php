<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureUser2FASetup;
use App\Http\Middleware\EnsureSessionExists;
use App\Http\Middleware\EnsureValidPasswordRequest;
use App\Http\Middleware\EnsureEmployeeSession;



// ORDER TRACKING FOR CLIENTS
Route::get('/tracking', [TrackingController::class, "tracking"]);
Route::post('/tracking', [TrackingController::class, "track"]);
Route::get('/tracking/display', [TrackingController::class, "display"]);

// LOGINS
Route::get('/', [LoginController::class, "login"]);
Route::post('/', [LoginController::class, "auth"]);
Route::post('/logout', [LoginController::class, "logout"]);

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

Route::get('/account', [UserController::class, "account"])->middleware(EnsureEmployeeSession::class);

// CRUD Orders, Clients, Payments, Employees
Route::resource('orders', OrderController::class)->middleware(EnsureEmployeeSession::class);

Route::resource('clients', ClientController::class)->middleware(EnsureEmployeeSession::class);

Route::resource('payments', PaymentController::class)->middleware(EnsureEmployeeSession::class);

Route::resource('employees', EmployeeController::class)->middleware(EnsureEmployeeSession::class);

Auth::routes();

