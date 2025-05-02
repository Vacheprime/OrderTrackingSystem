<?php

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
Route::get('/', function () {
    return view('login.index');
});

Route::get('/qr2fa', function () {
    return view('login.qrverification');
});

Route::get('/code2fa', function () {
    return view('login.codeverification');
});

Route::get('/contactmethod', function () {
    return view('login.contactmethod');
});

Route::get('/newpassword', function () {
    return view('login.newpassword');
});

// NORMAL SHIT
Route::get('/home', function () {
    return view('home');
});

Route::get('/settings', function () {
    return view('user.settings');
});

Route::get('/account', function () {
    return view('user.account');
});


Route::resource('orders', OrderController::class);

Route::resource('clients', ClientController::class);

Route::resource('payments', PaymentController::class);

Route::resource('employees', EmployeeController::class);
