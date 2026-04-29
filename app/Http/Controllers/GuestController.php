<?php

namespace App\Http\Controllers;

class GuestController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function twoFactor()
    {
        return view('auth.two-factor');
    }

    public function invitation()
    {
        return view('user.invitation');
    }
    public function identification()
    {
        return view('user.identification');
    }
    public function upload()
    {
        return view('user.televersement');
    }
    public function confirmation()
    {
        return view('user.confirmation');
    }
}