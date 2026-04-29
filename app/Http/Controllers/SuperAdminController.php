<?php

namespace App\Http\Controllers;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('super-admin.dashboard');
    }
    public function logs()
    {
        return view('super-admin.logs');
    }
    public function settings()
    {
        return view('super-admin.settings');
    }
    public function creationAdmin()
    {
        return view('super-admin.creation-admin');
    }
}