<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function settings() {
        return view("user.settings");
    }

    public function account() {
        return view("user.account");
    }
}
