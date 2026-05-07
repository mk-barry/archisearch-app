<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function evenements()
    {
        return view('admin.evenements');
    }
    public function creationEvent()
    {
        return view('admin.creation-events');
    }
    public function documents()
    {
        return view('admin.documents');
    }
    public function recherche()
    {
        return view('admin.recherche');
    }
    public function archives()
    {
        return view('admin.archives');
    }
    public function cloud()
    {
        return view('admin.cloud');
    }
}