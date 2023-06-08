<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function manager_index()
    {
        return view('manager_dashboard');
    }
    public function staff_index()
    {
        return view('staff_dashboard');
    }
}
