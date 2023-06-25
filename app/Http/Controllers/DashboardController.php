<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deceased;
use DB;
class DashboardController extends Controller
{
    public function manager_index()
    {
        // $data = DB::select('select * from deceaseds where dateof_burial >= 2000-01-01 AND dateof_burial <= '.now()->format('Y-m-d').'');
        $years = DB::select('select distinct YEAR(dateof_death) as year from deceaseds where approvalStatus = 1 group by YEAR(dateof_death) asc');
        $deaths_label = [];
        $deaths_values = [];
        $no_ofdeceaseds = Deceased::where('approvalStatus', 1)->count();
        //Kuhaon sa niya ang mga YEARS sa tanan mga deceased kanus siya namatay 
        foreach($years as $year)
        {   
            $deaths_label[] = $year->year;
            //iya dayon e count pila kabook ang namatay ana nga year
            $deceased = DB::select('select count(id) as y from deceaseds where approvalStatus = 0 and YEAR(dateof_death) = '.$year->year.' ');

            $deaths_values[] = $deceased[0]->y;
        }
        return view('manager_dashboard', compact('deaths_values', 'deaths_label', 'no_ofdeceaseds'));
    }
    public function staff_index()
    {
        // return view('staff_dashboard');
    }
}
