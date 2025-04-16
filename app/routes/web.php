<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    //  return main
});

// ### Address Routing ###
Route::resource('addresses', AddressController::class);


// ### Client Routing ###
Route::resource('clients', ClientController::class);


// ### Employee Routing ###
Route::resource('employees', EmployeeController::class);


// ### Order Routing ###
Route::resource('orders', OrderController::class);


// ### OrderProduct Routing ###
Route::resource('products', OrderProductController::class);


// ### Payment Routing ###
Route::resource('payments', PaymentController::class);

