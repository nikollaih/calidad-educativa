<?php

namespace App\Http\Controllers;

class PAMController extends Controller
{
    public function index()
    {
        return view('pam.index');
    }
    public function matriz()
    {
        return view('pam.matriz');
    }
    public function forms_ie_pestanas()
    {
        return view('pam.forms_ie_pestanas');
    }
    public function forms_ie()
    {
        return view('pam.forms_ie');
    }
}
