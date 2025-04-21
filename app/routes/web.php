<?php

use Illuminate\Support\Facades\Route;
use app\models\Order;

Route::get('/', function () {
    $clients = null;
    return view('login.index');
});

// TODO: ROUTING TO BE IMPLEMENTED CORRECTLY THIS IS FOR TO SEE IF THINGS WORK

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

Route::get('/orders/create', function() {
    return view('orders.createedit');
});

Route::get('/clients', function() {
    return view('clients.index');
});

Route::get('/payments', function() {
    return view('payments.index');
});

Route::get('/employees', function() {
    return view('employees.index');
});


