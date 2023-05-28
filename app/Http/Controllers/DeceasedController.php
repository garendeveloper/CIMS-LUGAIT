<?php

namespace App\Http\Controllers;

use App\Models\deceased;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;
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
                    'dateof_death' => 'required',
                    'dateofbirth' => 'required',
                    'dateof_burial' => 'required',
                    'burial_time' => 'required',
                    'region' => 'required',
                    'province' => 'required',
                    'city' => 'required',
                    'barangay' => 'required',
                    'causeofdeath' => 'required',
                    'service_id' => 'required',
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
                    'dateof_death' => 'required',
                    'dateofbirth' => 'required',
                    'dateof_burial' => 'required',
                    'burial_time' => 'required',
                    'region' => 'required',
                    'province' => 'required',
                    'city' => 'required',
                    'barangay' => 'required',
                    'region1' => 'required',
                    'province1' => 'required',
                    'city1' => 'required',
                    'barangay1' => 'required',
                    'causeofdeath' => 'required',
                    'service_id' => 'required',
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
                    'region' => $request->region_text,
                    'province_no' => $request->province,
                    'province' => $request->province_text,
                    'city_no' => $request->city,
                    'city' => $request->city_text,
                    'barangay_no' => $request->barangay,
                    'barangay' => $request->barangay_text
                ])->count();

                if($address > 0)
                {
                    $address = 1;
                }
                else
                {
                    $address = new Address;
                    $address->region_no = $request->region;
                    $address->region = $request->region_text;
                    $address->province_no = $request->province;
                    $address->province = $request->province_text;
                    $address->city_no = $request->city;
                    $address->city = $request->city_text;
                    $address->barangay_no = $request->barangay;
                    $address->barangay = $request->barangay_text;
                    $address->save();
                }
            }
            $json = [
                'status' => $status,
                'message' => $message,
            ];
            return response()->json($json);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(deceased $deceased)
    {
        //
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
