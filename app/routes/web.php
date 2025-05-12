<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

// ORDER TRACKING FOR CLIENTS

Route::get('/tracking', function () {
    return view('tracking.order-input');
});

Route::get('/tracking/display', function (Request $request) {
    return view('tracking.order-display');
});

// LOGINS
Route::get('/', [LoginController::class, "login"]);
Route::post('/', [LoginController::class, "auth"]);
Route::post('/logout', [LoginController::class, "logout"]);

Route::get('/qr2fa', [LoginController::class, "qr2fa"]);
Route::post('/qr2fa', [LoginController::class, "authQR"]);

Route::get('/code2fa', [LoginController::class, "code2fa"]);
Route::post('/code2fa', [LoginController::class, "authCode"]);

Route::get('/contact', [LoginController::class, "contact"]);
Route::post('/contact', [LoginController::class, "authContact"]);

Route::get('/newpassword', [LoginController::class, "newPassword"]);
Route::post('/newpassword', [LoginController::class, "authPassword"]);

// Account Specific
Route::get('/home', [HomeController::class, "index"]);

Route::get('/settings', [UserController::class, "settings"]);

Route::get('/account', [UserController::class, "account"]);

// CRUD Orders, Clients, Payments, Employees
Route::resource('orders', OrderController::class);

Route::resource('clients', ClientController::class);

Route::resource('payments', PaymentController::class);

Route::resource('employees', EmployeeController::class);
