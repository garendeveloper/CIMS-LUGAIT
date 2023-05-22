<?php

namespace App\Http\Controllers;

use \Auth;
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
        Auth::logout();
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

        $response = [
            'status' => 0,
            'message' => 'Email or Password in invalid!',
        ];
        if($validate->fails())
        {
            $response = [
                'status' => 2,
                'message' => $validate->messages(),
            ];
        }
        else
        {
            $data = [
                'email' => $email,
                'password' => $password
            ];
            if(Auth::attempt($data))
            {
                $response = [
                    'status' => 1,
                    'message' => 'You are successfully login!',
                ];
            }
        }
        echo json_encode($response);
    }
}
