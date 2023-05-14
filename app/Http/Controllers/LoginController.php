<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);
        
        if($validate->fails())
        {
            echo json_encode($validate->messages());
        }
        else
        {
            $data = [
                'email' => $email,
                'password' => $password
            ];
            $check_credentials = User::where($data)->count();
            $status = 0;
            if($check_credentials > 0)
            {
                $status = 1;
            }
            echo json_encode($status);
        }
    }
    public function manager_dashboard()
    {
        return view('manager_dashboard');
    }
}
