<?php

use Illuminate\Support\Facades\Route;
use app\models\Order;

Route::get('/', function () {
    return view('login.index');
});

// TODO: ROUTING TO BE IMPLEMENTED CORRECTLY THIS IS FOR TO SEE IF THINGS WORK
// LOGINS
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
Route::get('/home', function() {
    return view('home');
});

Route::get('/settings', function() {
    return view('user.settings');
});

Route::get('/account', function() {
    return view('user.account');
});

Route::get('/orders', function() {
    return view('orders.index')->with('orders',
        [
            ["1", "1", "1", "AC", "23-12-2025", "COMPLETED"],
            ["2", "2", "2", "DA", "23-12-2025", "COMPLETED"],
            ["3", "3", "3", "LY", "23-12-2025", "COMPLETED"],
        ]);
});

Route::get('/orders/edit', function() {
    return view('orders.edit');
});

Route::get('/orders/create', function() {
    return view('orders.create');
});


Route::get('/clients', function() {
    return view('clients.index');
});

Route::get('/payments', function() {
    return view('payments.index')->with('payments', [
        ["1", "1", "1", "1"]
    ]);
});

Route::get('/payments/create', function() {
    return view('payments.create');
});

Route::get('/payments/edit', function() {
    return view('payments.edit');
});

Route::get('/employees', function() {
    return view('employees.index');
});


