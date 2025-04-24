<?php

use Illuminate\Support\Facades\Route;

// TODO: ROUTING TO BE IMPLEMENTED CORRECTLY THIS IS FOR TO SEE IF THINGS WORK

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


Route::resource('orders', \App\Http\Controllers\OrdersController::class);

//Route::get('/orders', function () {
//    return view('orders.index')->with('orders', );
//});
//
//Route::get('/orders/edit', function () {
//    return view('orders.edit');
//});
//
//Route::get('/orders/create', function () {
//    return view('orders.create');
//});


Route::get('/clients', function () {
    return view('clients.index')->with('clients', [
        ["1", "1", "1", "1", "1", "1", "1"]
    ]);
});

Route::get('/clients/create', function () {
    return view('clients.create');
});

Route::get('/clients/edit', function () {
    return view('clients.edit');
});

Route::get('/payments', function () {
    return view('payments.index')->with('payments', [
        ["1", "1", "1", "1"]
    ]);
});

Route::get('/payments/create', function () {
    return view('payments.create');
});

Route::get('/payments/edit', function () {
    return view('payments.edit');
});

Route::get('/employees', function () {
    return view('employees.index')->with('employees', [
        ["", "","","","","","",""]
    ]);
});

Route::get('/employees/create', function () {
    return view('employees.create');
});
Route::get('/employees/edit', function () {
    return view('employees.edit');
});

