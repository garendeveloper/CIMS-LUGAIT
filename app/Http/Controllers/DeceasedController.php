<?php

namespace App\Http\Controllers;

use App\Models\deceased;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;
use App\Models\User;
use DB;
class DeceasedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('deceasedpage');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->ajax())
        {
            $validator = Validator::make($request->all(), []);
            if($request->sameaddress == 1)
            {
                $validator = Validator::make($request->all(), [
                    'lastname' => 'required',
                    'middlename' => 'required',
                    'firstname' => 'required',
                    'suffix' => 'required',
                    'dateof_death' => 'required',
                    'dateofbirth' => 'required',
                    'dateof_burial' => 'required',
                    'burial_time' => 'required',
                    'civilstatus' => 'required|in:S,M,W,D',
                    'sex' => 'required|in:M,F',
                    'region' => 'required',
                    'province' => 'required',
                    'city' => 'required',
                    'causeofdeath' => 'required',
                    'contactperson' => 'required',
                    'relationship' => 'required',
                    'contactnumber' => 'required|min:11|max:11',
                    'sameaddress' => 'required',
                ]);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                    'lastname' => 'required',
                    'middlename' => 'required',
                    'firstname' => 'required',
                    'suffix' => 'required',
                    'dateof_death' => 'required',
                    'dateofbirth' => 'required',
                    'dateof_burial' => 'required',
                    'burial_time' => 'required',
                    'civilstatus' => 'required|in:S,M,W,D',
                    'sex' => 'required|in:M,F',
                    'region' => 'required',
                    'province' => 'required',
                    'city' => 'required',
                    'region1' => 'required',
                    'province1' => 'required',
                    'city1' => 'required',
                    'causeofdeath' => 'required',
                    'contactperson' => 'required',
                    'relationship' => 'required',
                    'contactnumber' => 'required|min:11|max:11',
                    'sameaddress' => 'required',
                ]);
            }
            $status = 0;
            $message = "";
            if($validator->fails())
            {
                $status = 2;
                $message = $validator->messages();
            }
            else
            {
                //Address

                $address = Address::where([
                    'region_no' => $request->region,
                    'region' => strtoupper($request->region_text),
                    'province_no' => $request->province,
                    'province' => strtoupper($request->province_text),
                    'city_no' => $request->city,
                    'city' => strtoupper($request->city_text),
                    'barangay_no' => $request->barangay,
                    'barangay' => strtoupper($request->barangay_text)
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
                
                $conperson_add;
                if($request->sameaddress == 1) 
                {
                    $conperson_add = $address;
                }
                else
                {
                    $conperson_add = Address::where([
                        'region_no' => $request->region1,
                        'region' => strtoupper($request->region_text1),
                        'province_no' => $request->province1,
                        'province' => strtoupper($request->province_text1),
                        'city_no' => $request->city1,
                        'city' => strtoupper($request->city_text1),
                        'barangay_no' => $request->barangay1,
                        'barangay' => strtoupper($request->barangay_text1)
                    ])->first();
    
                    if($conperson_add !== null)
                    {
                        $conperson_add = $conperson_add->id;
                    }
                    else
                    {
                        $conperson_add = new Address;
                        $conperson_add->region_no = $request->region1;
                        $conperson_add->region = strtoupper($request->region_text1);
                        $conperson_add->province_no = $request->province1;
                        $conperson_add->province =  strtoupper($request->province_text1);
                        $conperson_add->city_no = $request->city1;
                        $conperson_add->city = strtoupper($request->city_text1);
                        $conperson_add->barangay_no = $request->barangay1;
                        $conperson_add->barangay = strtoupper($request->barangay_text1);
                        $conperson_add->save();
                        $conperson_add = $conperson_add->id;
                    }
    
                }

                $contactperson = User::where([
                    'role' => 3,
                    'address_id' => $conperson_add,
                    'name' => strtoupper($request->contactperson),
                ])->first();

                if($contactperson !== null)
                {
                    $contactperson = $contactperson->id;
                }
                else
                {
                    $contactperson = new User();
                    $contactperson->role = 3;
                    $contactperson->name = strtoupper($request->contactperson);
                    $contactperson->contactnumber = $request->contactnumber;
                    $contactperson->relationshipthdeceased = $request->relationship;
                    $contactperson->address_id = $conperson_add;
                    $contactperson->save();
                    $contactperson = $contactperson->id;
                }

                //Add Deceased
                $deceased = Deceased::where([
                    'service_id' => 1,
                    'address_id' => $address,
                    'contactperson_id' => $contactperson,
                    'causeofdeath' => $request->causeofdeath,
                    'lastname' => strtoupper($request->lastname),
                    'middlename' => strtoupper($request->middlename),
                    'firstname' => strtoupper($request->firstname),
                    'suffix' => strtoupper($request->suffix),
                    'civilstatus' => $request->civilstatus,
                    'sex' => $request->sex,
                    'dateof_death' => $request->dateof_death,
                    'dateof_burial' => $request->dateof_burial,
                    'burial_time' => $request->burial_time,
                    'dateofbirth' => $request->dateofbirth,
                ])->first();

                if($deceased !== null)
                {
                    $status = 0;
                    $message = "Deceased already exists.";
                }
                else
                {
                    $deceased = new Deceased;
                    $deceased->service_id = 1;
                    $deceased->address_id = $address;
                    $deceased->contactperson_id = $contactperson;
                    $deceased->causeofdeath = $request->causeofdeath;
                    $deceased->lastname = strtoupper($request->lastname);
                    $deceased->middlename = strtoupper($request->middlename);
                    $deceased->firstname = strtoupper($request->firstname);
                    $deceased->suffix = strtoupper($request->suffix);
                    $deceased->civilstatus = $request->civilstatus;
                    $deceased->sex = $request->sex;
                    $deceased->dateof_death = $request->dateof_death;
                    $deceased->dateof_burial = $request->dateof_burial;
                    $deceased->burial_time = $request->burial_time;
                    $deceased->dateofbirth = $request->dateofbirth;
                    $deceased->save();

                    $status = 1;
                    $message = "Deceased has been successfully registered.";
                }
            }
            $json = [
                'status' => $status,
                'message' => $message,
            ];
            return response()->json($json);
        }
    }

    public function get_allData()
    {
        $data = DB::select('select addresses.*, services.*, users.*, deceaseds.*, deceaseds.id as deceased_id
                            from addresses, users, deceaseds, services
                            where addresses.id = deceaseds.address_id
                            and services.id = deceaseds.service_id
                            and users.id = deceaseds.contactperson_id');
        return response()->json($data);
    }

    public function show($deceased_id)
    {
        $deceased_info = DB::select('select addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
        from addresses, deceaseds, services
        where addresses.id = deceaseds.address_id
        and services.id = deceaseds.service_id
        and deceaseds.id = '.$deceased_id.'');

        $deceased_asssigment =  DB::select('select blocks.*, deceaseds.id as deceased_id, deceaseds.*, coffinplots.*
        from blocks, deceaseds, coffinplots
        where blocks.id = coffinplots.block_id
        and deceaseds.id = coffinplots.deceased_id
        and deceaseds.id = '.$deceased_id.'');

        $contactperson =  DB::select('SELECT users.*, deceaseds.id as deceased_id, addresses.*
                                        FROM users, deceaseds, addresses
                                        where users.id = deceaseds.contactperson_id
                                        and addresses.id = users.address_id
                                        and deceaseds.id = '.$deceased_id.'');

        $data = [ $deceased_info, $deceased_asssigment, $contactperson];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deceased $deceased)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, deceased $deceased)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(deceased $deceased)
    {
        //
    }
}
