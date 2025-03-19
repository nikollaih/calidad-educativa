<?php

namespace App\Http\Controllers;

class PEIController extends Controller
{
    public function autoevaluation()
    {
        return view('pei.autoevaluation');
    }
    public function academicManagement()
    {
        return view('pei.academic_management');
    }
    public function communityManagement()
    {
        return view('pei.community_management');
    }
    public function executiveManagement()
    {
        return view('pei.executive_management');
    }
}
