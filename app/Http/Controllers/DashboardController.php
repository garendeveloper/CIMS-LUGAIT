<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deceased;
use DB;
class DashboardController extends Controller
{
    public function manager_index()
    {
        $data = DB::select('select * from deceaseds where dateof_burial >= 2000-01-01 AND dateof_burial <= '.now()->format('Y-m-d').'');
        return view('manager_dashboard', compact('data'));
    }
    public function staff_index()
    {
        return view('staff_dashboard');
    }
}
