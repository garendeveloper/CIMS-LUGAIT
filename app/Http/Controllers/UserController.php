<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
class UserController extends Controller
{
    public function index()
    {
        return view('users');
    }
    public function data()
    {
        $users = User::where('role', 1)->orWhere('role', 2);
       
        return datatables()->of($users)
                        ->addColumn('role', function($row){
                            $html = '<span class = "badge badge-primary">STAFF</span>';
                            if($row->role == 1)
                            {
                                $html = '<span class = "badge badge-success">MANAGER / CEMETERY IN-CHARGE</span>';
                            }
                            return $html;
                        })
                        ->addColumn('action', function ($row) {
                            $html = '<button align = "center" data-rowid="'.$row->id.'" id = "btn_edit" class="btn btn-xs btn-secondary"><i class = "fa fa-edit"></i></button> ';
                            $html .= '<button align= "center" data-rowid="'.$row->id.'" id = "btn_del"  class="btn btn-xs btn-danger"><i class = "fa fa-trash"></i></button>';
                            return $html;
                        })
                        ->rawColumns(['role', 'action'])
                        ->make(true);

        
    }
    public function store(Request $request)
    {
        if($request->ajax())
        {
            $validator = Validator::make($request->all(), [
                'region' => 'required',
                'province' => 'required',
                'city' => 'required',
            ]);

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
                ]);

                if($user !== null)
                {
                    $status = 500;
                    $messages = "Name already exists";
                }
                else
                {
                    $user = new User();
                    $user->role = 2;
                    $user->name = strtoupper($request->name);
                    $user->contactnumber = "63".$request->contactnumber;
                    $user->address_id = $address;
                    $user->email = $request->email;
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
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:users,name,'.$user_id.',id',
                'contactnumber' => 'required|min:10|max:10',
                'email' => 'required|email',
                'region' => 'required',
                'province' => 'required',
                'city' => 'required',
            ]);

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
            'messages' => "User successfully activated",
        ]);
    }
    public function deactivate($user_id)
    {
        $user = User::find($user_id);
        $user->status = 0;
        $user->update();
        return response()->json([
            'status' => 200,
            'messages' => "User successfully deactivated",
        ]);
    }
}
