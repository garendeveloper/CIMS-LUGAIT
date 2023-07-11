<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index()
    {
        return view('users');
    }
    public function show($user_id)
    {
        $user_details = DB::select('select addresses.*, users.* from users, addresses where addresses.id = users.address_id and users.id = '.$user_id.'');
        return response()->json($user_details);
    }
    public function data()
    {
        $users = User::where('role', 1)->orWhere('role', 2)->orderby('id', 'asc');
       
        return datatables()->of($users)
                        ->addColumn('role', function($row){
                            $html = '<span class = "badge badge-primary">STAFF</span>';
                            if($row->role == 1)
                            {
                                $html = '<span class = "badge badge-success">MANAGER / CEMETERY IN-CHARGE</span>';
                            }
                            return $html;
                        })
                        ->addColumn('status', function($row){
                            $html = '<span class = "badge badge-secondary">OFFLINE</span>';
                            if($row->systemstatus == 1)
                            {
                                $html = '<span class = "badge badge-success">ONLINE</span>';
                            }
                            return $html;
                        })
                        ->addColumn('action', function ($row) {
                            $html = '<button align = "center" data-rowid="'.$row->id.'" id = "btn_edit" class="btn btn-xs btn-secondary"><i class = "fa fa-edit"></i></button> ';
                            if($row->role == 1)
                            {
                                $html = '<button id = "myprofile" data-rowid="'.$row->id.'" class = "btn btn-xs btn-primary">MY PROFILE</button>';
                            }
                            else
                            {
                                if($row->status == 1)
                                {
                                    $html .= '<button align= "center" data-rowid="'.$row->id.'" id = "btn_deactivate"  class="btn btn-xs btn-danger"><i class = "fa fa-lock"></i></button>';
                                }
                                else
                                {
                                 $html .= '<button align= "center" data-rowid="'.$row->id.'" id = "btn_activate"  class="btn btn-xs btn-primary"><i class = "fa fa-unlock"></i></button>';
                                }
                            }
                            return $html;
                        })
                        ->rawColumns(['role', 'status', 'action'])
                        ->make(true);

        
    }
    public function store(Request $request)
    {
        if($request->ajax())
        {
            $validations = [
                'name' => 'required|string',
                'contactnumber' => 'required|min:10|max:10',
                'email' => 'required|email|unique:users',
                'region' => 'required',
                'province' => 'required',
                'city' => 'required',
            ];
            $validator = Validator::make($request->all(), $validations);
            $messages = "";
            $status = 0;
            if($validator->fails())
            {
                $messages = $validator->messages();
                $status = 500;
            }
            else
            {
                $address = DB::table('addresses')->select('id')->where([
                    'region_no' => $request->region,
                    'province_no' => $request->province,
                    'city_no' => $request->city,
                    'barangay_no' => $request->barangay,
                ])->first();
                if($address !== null)
                {
                    $address = $address->id;
                }
                else
                {
                    $address = new Address;
                    $address->region_no = $request->region;
                    $address->region = strtoupper($request->region_text);
                    $address->province_no = $request->province;
                    $address->province =  strtoupper($request->province_text);
                    $address->city_no = $request->city;
                    $address->city = strtoupper($request->city_text);
                    $address->barangay_no = $request->barangay;
                    $address->barangay = strtoupper($request->barangay_text);
                    $address->save();
                    $address = $address->id;
                }
               
                $user = User::where([
                    'name' => $request->name,
                    'address_id' => $address,
                ])->first();

                if($user !== null)
                {
                    $status = 500;
                    $messages = "User details is existing.";
                }
                else
                {
                    $user = new User();
                    $user->role = 2;
                    $user->name = strtoupper($request->name);
                    $user->contactnumber = "63".$request->contactnumber;
                    $user->address_id = $address;
                    $user->email = $request->email;
                    $user->role = 2;
                    $user->password = Hash::make("password");
                    $user->save();

                    $status   = 200;
                    $messages = "User has been successfully added.";
                }
            }
            return response()->json([
                'status' => $status,
                'messages' => $messages,
            ]);
        }
    }
    public function update(Request $request, $user_id)
    {
        if($request->ajax())
        {
            $messages = "";
            $status = 0;
            $user = User::find($user_id);
            if($request->role == "1")
            {
                if($user->role == 1)
                {
                    $validations = [];
                    if($request->changepass == "1")
                    {
                        if($request->address_id != "")
                        {
                            $validations = [
                                'name' => 'required|string|unique:users,name,'.$user_id.',id',
                                'contactnumber' => 'required|min:10|max:10',
                                'email' => 'required|email|unique:users,email,'.$user_id.',',
                                'curr_pwd' => 'required|min:6',
                                'new_pwd' => 'required|min:6',
                                'con_pwd' => 'required|min:6',
                            ];
                        }
                        else
                        {
                            $validations = [
                                'name' => 'required|string|unique:users,name,'.$user_id.',id',
                                'contactnumber' => 'required|min:10|max:10',
                                'email' => 'required|email|unique:users,email,'.$user_id.',',
                                'region' => 'required',
                                'province' => 'required',
                                'city' => 'required',
                                'curr_pwd' => 'required|min:6',
                                'new_pwd' => 'required|min:6',
                                'con_pwd' => 'required|min:6',
                            ];
                        }
                    }
                    else
                    {
                        
                        if($request->address_id != "")
                        {
                            $validations = [
                                'name' => 'required|string|unique:users,name,'.$user_id.',id',
                                'contactnumber' => 'required|min:10|max:10',
                                'email' => 'required|email|unique:users,email,'.$user_id.',',
                            ];
                        }
                        else
                        {
                            $validations = [
                                'name' => 'required|string|unique:users,name,'.$user_id.',id',
                                'contactnumber' => 'required|min:10|max:10',
                                'email' => 'required|email|unique:users,email,'.$user_id.',',
                                'region' => 'required',
                                'province' => 'required',
                                'city' => 'required',
                            ];
                        }
                    }

                    $validator = Validator::make($request->all(), $validations);
                    if($validator->fails())
                    {
                        $messages = $validator->messages();
                        $status = 500;
                    }
                    else
                    {
                        $address = $request->address_id;
                        if($request->address_id == "")
                        {
                            $address = DB::table('addresses')->select('id')->where([
                                'region_no' => $request->region,
                                'province_no' => $request->province,
                                'city_no' => $request->city,
                                'barangay_no' => $request->barangay,
                            ])->first();
            
                            if($address !== null)
                            {
                                $address = $address->id;
                            }
                            else
                            {
                                $address = new Address;
                                $address->region_no = $request->region;
                                $address->region = strtoupper($request->region_text);
                                $address->province_no = $request->province;
                                $address->province =  strtoupper($request->province_text);
                                $address->city_no = $request->city;
                                $address->city = strtoupper($request->city_text);
                                $address->barangay_no = $request->barangay;
                                $address->barangay = strtoupper($request->barangay_text);
                                $address->save();
                                $address = $address->id;
                            }
                        }
                        if($request->changepass == "1")
                        {
                            if(Hash::check($request->curr_pwd, $user->password))
                            {
                                if($request->new_pwd === $request->con_pwd)
                                {
                                    $user->name = strtoupper($request->name);
                                    $user->contactnumber = "63".$request->contactnumber;
                                    $user->address_id = $address;
                                    $user->email = $request->email;
                                    $user->password = Hash::make($request->con_pwd);
                                    $user->update();
                                    $status   = 200;
                                    $messages = "User details has been successfully updated.";
                                }
                                else
                                {
                                    $status = 500;
                                    $messages = [
                                        'new_pwd' => "Password does not match",
                                        'con_pwd' => "Password does not match",
                                    ];
                                }
                                
                            }
                            else
                            {
                                $status = 500;
                                $messages = [
                                    'curr_pwd' => "Invalid Password",
                                ];
                            }
                        }
                        else
                        {
                            $user->name = strtoupper($request->name);
                            $user->contactnumber = "63".$request->contactnumber;
                            $user->address_id = $address;
                            $user->email = $request->email;
                            $user->update();
                            $status   = 200;
                            $messages = "User details has been successfully updated.";
                        }
                    }
                }
                else
                {
                    $status = 500;
                    $messages = "User is not the admin.";
                }
            }
            else
            {
                $validations = [];
                if($request->address_id != "")
                {
                    $validations = [
                        'name' => 'required|string|unique:users,name,'.$user_id.',id',
                        'contactnumber' => 'required|min:10|max:10',
                        'email' => 'required|email|unique:users,email,'.$user_id.',',
                    ];
                }
                else
                {
                    $validations = [
                        'name' => 'required|string|unique:users,name,'.$user_id.',id',
                        'contactnumber' => 'required|min:10|max:10',
                        'email' => 'required|email|unique:users,email,'.$user_id.',',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                    ];
                }
                $validator = Validator::make($request->all(), $validations);
               
                if($validator->fails())
                {
                    $messages = $validator->messages();
                    $status = 500;
                }
                else
                {
                    $address = $request->address_id;
                    if($request->address_id == "")
                    {
                        $address = DB::table('addresses')->select('id')->where([
                            'region_no' => $request->region,
                            'province_no' => $request->province,
                            'city_no' => $request->city,
                            'barangay_no' => $request->barangay,
                        ])->first();
        
                        if($address !== null)
                        {
                            $address = $address->id;
                        }
                        else
                        {
                            $address = new Address;
                            $address->region_no = $request->region;
                            $address->region = strtoupper($request->region_text);
                            $address->province_no = $request->province;
                            $address->province =  strtoupper($request->province_text);
                            $address->city_no = $request->city;
                            $address->city = strtoupper($request->city_text);
                            $address->barangay_no = $request->barangay;
                            $address->barangay = strtoupper($request->barangay_text);
                            $address->save();
                            $address = $address->id;
                        }
                    }
    
                    $user = User::find($user_id);
                    $user->role = 2;
                    $user->name = strtoupper($request->name);
                    $user->contactnumber = "63".$request->contactnumber;
                    $user->address_id = $address;
                    $user->email = $request->email;
                    $user->update();
    
                    $status   = 200;
                    $messages = "User details has been successfully updated.";
                   
                }
            }
            
            return response()->json([
                'status' => $status,
                'messages' => $messages,
            ]);
        }
    }
    public function activate($user_id)
    {
        $user = User::find($user_id);
        $user->status = 1;
        $user->update();
        return response()->json([
            'status' => 200,
            'message' => "User successfully activated",
        ]);
    }
    public function deactivate($user_id)
    {
        $user = User::find($user_id);
        $user->status = 0;
        $user->update();
        return response()->json([
            'status' => 200,
            'message' => "User successfully deactivated",
        ]);
    }
}
