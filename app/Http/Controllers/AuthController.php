<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('welcome');
    }

    public function getRegistration()
    {
        return view('welcome');
    }

    public function login()
    {
        return redirect('/home');
    }

    public function register()
    {

    }
}
