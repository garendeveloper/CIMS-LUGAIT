<?php

namespace App\Http\Controllers;

use App\Models\deceased;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;
use App\Models\User;
use App\Models\ContactPerson;
use App\Models\CoffinPlot;
use App\Models\Block;
use App\Models\Services;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class DeceasedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('deceasedpage');
    }
    public function deceasedForApproval()
    {
        return view('deceasedForApproval');
    }
    public function printpage($deceased_id)
    {
        $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
        from addresses, deceaseds, services
        where addresses.id = deceaseds.address_id
        and services.id = deceaseds.service_id
        and deceaseds.id = '.$deceased_id.'');

        //Block Area
        //E check niya block kung aha gi pili para sa deceased .Para pag abot sa view dali ra e check ang checkbox kinsa ang selected nga blocks
        $blocks = Block::all();
        $block_data = [];
        foreach($blocks as $b)
        {
            $isPlotted = CoffinPlot::where([
                'deceased_id' => $deceased_id,
                'block_id' => $b->id,
            ])->exists();

            if($isPlotted)
            {
                $block_data[] = [
                    'id' => $b->id,
                    'section_name' => $b->section_name,
                    'block_cost' => $b->block_cost,
                    'isPlotted' => 1,
                ];
            }
            else
            {
                $block_data[] = [
                    'id' => $b->id,
                    'section_name' => $b->section_name,
                    'block_cost' => $b->block_cost,
                    'isPlotted' => 0,
                ];
            }
        }

        //Service Area
        //E check niya block kung aha gi pili para sa deceased. Para pag abot sa view dali ra e check ang checkbox kinsa ang selected nga services
        $services = Services::all();
        $service_data = [];
        foreach($services as $s)
        {
            $is_selected = Deceased::where([
                'id' => $deceased_id,
                'service_id' => $s->id,
            ])->exists();

            if($is_selected)
            {
                $service_data[] = [
                    'id' => $s->id,
                    'service_name' => $s->service_name,
                    'is_selected' => 1,
                ];
            }
            else
            {
                $service_data[] = [
                    'id' => $s->id,
                    'service_name' => $s->service_name,
                    'is_selected' => 0,
                ];
            }
        }

        $contactpeople = DB::select('select users.*, addresses.* from users, addresses, deceaseds, contactpeople where users.id = contactpeople.user_id and deceaseds.id = contactpeople.deceased_id and users.address_id = addresses.id  and users.role = 3 and deceaseds.id = '.$deceased_id.'');
        $data = [
            'deceased_info' => $deceased_info,
            'blocks' => $block_data,
            'services' => $service_data,
            'contactpeople' => $contactpeople,
        ];
        return view('printpage', compact('data'));
    }
    public function approve($deceased_id)
    {   
        $deceased = Deceased::find($deceased_id);
        
        $contactpeople = ContactPerson::where('deceased_id', $deceased_id)->get();
        if(!empty($contactpeople))
        {
            foreach($contactpeople as $cp)
            {
                $customer = User::find($cp->user_id);

                if(!empty($customer))
                {
                    $basic  = new \Vonage\Client\Credentials\Basic("a4d8c8ee", "3KGO3b6Cdb9EW2FW");
                    $client = new \Vonage\Client($basic);
                    
                    $response = $client->sms()->send(
                        new \Vonage\SMS\Message\SMS($customer->contactnumber, "LCIMS", 'A text message from Lugait Cemetery System.')
                    );
                    
                    $message = $response->current();
            
                    if($message->getStatus() == 0)
                    {
                        $deceased->approvalStatus = 1;
                        $deceased->update();
                        return response()->json([
                            'status' => 1,
                            'message' => 'Deceased has been successfully approved',
                        ]); 
                    }
                    else
                    {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Cannot find a person contact number',
                        ]); 
                    }
                }
            }
        }
        return response()->json([
            'status' => 0,
            'message' => 'Cannot find a person',
        ]); 
    }
    public function get_deceasedLessThanValidity()
    {
        $data = DB::select('select deceaseds.*
                            from deceaseds, blocks, coffinplots 
                            where blocks.id =  coffinplots.block_id
                            and deceaseds.id = coffinplots.deceased_id
                            and year(curdate()) - year(deceaseds.dateof_burial) < blocks.validity');
        return response()->json($data);
    }
    public function get_allMaturity()
    {
        $data = DB::select('select deceaseds.*, blocks.*, deceaseds.id as deceased_id
                            from deceaseds, blocks, coffinplots 
                            where blocks.id =  coffinplots.block_id
                            and deceaseds.id = coffinplots.deceased_id');
        return response()->json($data);
    }
    public function nearingmaturity()
    {
        return view('nearingmaturity');
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
            $validations = [];
            if($request->addcontactperson == 1)
            {
                if($request->sameaddress == 1 AND $request->sameaddress1 == 1)
                {
                    $validations = [
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
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                    ];
                }
                else if($request->sameaddress == 0 AND $request->sameaddress1 == 1)
                {
                    $validations = [
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
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                    ];
                }
                //if other contact person has sameaddresss
                else if($request->sameaddress == 1 AND $request->sameaddress1 == 0)
                {
                    $validations = [
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
                        'region2' => 'required',
                        'province2' => 'required',
                        'city2' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                    ];
                }
                else
                {
                    $validations = [
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
                        'region2' => 'required',
                        'province2' => 'required',
                        'city2' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                    ];
                }
            }
            else
            {
                if($request->sameaddress == 1)
                {
                    $validations = [
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
                        'contactnumber' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                    ];
                }
                else
                {
                    $validations = [
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
                        'contactnumber' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                    ];
                }
            }
            $validator = Validator::make($request->all(), $validations);

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
                
                $conperson_add;
                if($request->sameaddress == 1) 
                {
                    $conperson_add = $address;
                }
                else
                {
                    $conperson_add = Address::where([
                        'region_no' => $request->region1,
                        'province_no' => $request->province1,
                        'city_no' => $request->city1,
                        'barangay_no' => $request->barangay1,
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

                //other contact person
                $contactperson1 = null;
                $conperson_add1 = null;
                if($request->addcontactperson == 1)
                {
                    if($request->sameaddress1 == 1) 
                    {
                        $conperson_add1 = $address;
                    }
                    else
                    {
                        $conperson_add1 = Address::where([
                            'region_no' => $request->region2,
                            'province_no' => $request->province2,
                            'city_no' => $request->city2,
                            'barangay_no' => $request->barangay2,
                        ])->first();
        
                        if($conperson_add1 !== null)
                        {
                            $conperson_add1 = $conperson_add1->id;
                        }
                        else
                        {
                            $conperson_add1 = new Address;
                            $conperson_add1->region_no = $request->region2;
                            $conperson_add1->region = strtoupper($request->region_text2);
                            $conperson_add1->province_no = $request->province2;
                            $conperson_add1->province =  strtoupper($request->province_text2);
                            $conperson_add1->city_no = $request->city2;
                            $conperson_add1->city = strtoupper($request->city_text2);
                            $conperson_add1->barangay_no = $request->barangay2;
                            $conperson_add1->barangay = strtoupper($request->barangay_text2);
                            $conperson_add1->save();
                            $conperson_add1 = $conperson_add1->id;
                        }
        
                    }
                    $contactperson1 = User::where([
                        'role' => 3,
                        'address_id' => $conperson_add1,
                        'name' => strtoupper($request->contactperson1),
                    ])->first();
    
                    if($contactperson1 !== null)
                    {
                        $contactperson1 = $contactperson->id;
                    }
                    else
                    {
                        $contactperson1 = new User();
                        $contactperson1->role = 3;
                        $contactperson1->name = strtoupper($request->contactperson1);
                        $contactperson1->contactnumber = $request->contactnumber1;
                        $contactperson1->relationshipthdeceased = $request->relationship1;
                        $contactperson1->address_id = $conperson_add1;
                        $contactperson1->save();
                        $contactperson1 = $contactperson1->id;
                    }
                }
                //Add Deceased
                $deceased = Deceased::where([
                    'service_id' => 1,
                    'address_id' => $address,
                    // 'contactperson_id' => $contactperson,
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
                    // $deceased->contactperson_id = $contactperson;
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

                    $dbcontactperson = new ContactPerson;
                    $dbcontactperson->user_id = $contactperson;
                    $dbcontactperson->deceased_id = $deceased->id;
                    $dbcontactperson->save();

                    if($contactperson1 !== null)
                    {
                        $dbcontactperson1 = new ContactPerson;
                        $dbcontactperson1->user_id = $contactperson1;
                        $dbcontactperson1->deceased_id = $deceased->id;
                        $dbcontactperson1->save();
                    }
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
        $data = DB::select('select addresses.*, services.*, deceaseds.*, deceaseds.id as deceased_id
                            from addresses, deceaseds, services
                            where addresses.id = deceaseds.address_id
                            and services.id = deceaseds.service_id
                            order by deceaseds.id desc');
        return response()->json($data);
    }
    public function show($deceased_id)
    {
        $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
        from addresses, deceaseds, services
        where addresses.id = deceaseds.address_id
        and services.id = deceaseds.service_id
        and deceaseds.id = '.$deceased_id.'');

        $deceased_asssigment =  DB::select('select blocks.*, deceaseds.id as deceased_id, deceaseds.*, coffinplots.*
        from blocks, deceaseds, coffinplots
        where blocks.id = coffinplots.block_id
        and deceaseds.id = coffinplots.deceased_id
        and deceaseds.id = '.$deceased_id.'');

        $contactperson =  DB::select('SELECT users.*, users.id as contactperson_id, deceaseds.id as deceased_id, addresses.id as address_id, addresses.*
                                    FROM users, deceaseds, addresses, contactpeople
                                    where addresses.id = users.address_id
                                    and users.id = contactpeople.user_id
                                    and deceaseds.id = contactpeople.deceased_id
                                    and deceaseds.id = '.$deceased_id.'
                                    order by users.id asc');

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
    public function updatenotification()
    {
        $new_notif_exists = Deceased::where([
            'new_notif' => 0
        ])->exists();
        if($new_notif_exists)
        {
            DB::table('deceaseds')->update(['new_notif'=> 1])->where('new_notif', 0);
        }
        return response()->json([
            'status' => 1,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update_deceased(Request $request, deceased $deceased)
    {
        if($request->ajax())
        {
            $validations = [];
            if($request->addcontactperson == 1)
            {
                if($request->sameaddress == 1 AND $request->sameaddress1 == 1)
                {
                    $validations = [
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
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                    ];
                }
                else if($request->sameaddress == 0 AND $request->sameaddress1 == 1)
                {
                    $validations = [
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
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                    ];
                }
                //if other contact person has sameaddresss
                else if($request->sameaddress == 1 AND $request->sameaddress1 == 0)
                {
                    $validations = [
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
                        'region2' => 'required',
                        'province2' => 'required',
                        'city2' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                    ];
                }
                else
                {
                    $validations = [
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
                        'region2' => 'required',
                        'province2' => 'required',
                        'city2' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                    ];
                }
            }
            else
            {
                if($request->sameaddress == 1)
                {
                    $validations = [
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
                        'contactnumber' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                    ];
                }
                else
                {
                    $validations = [
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
                        'contactnumber' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                    ];
                }
            }
            $validator = Validator::make($request->all(), $validations);

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
                    if($request->barangay != null)
                    {
                        $address->barangay_no = $request->barangay;
                        $address->barangay = strtoupper($request->barangay_text);
                    }
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
                        'province_no' => $request->province1,
                        'city_no' => $request->city1,
                        'barangay_no' => $request->barangay1,
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
                        if($request->barangay1 != null)
                        {
                            $conperson_add->barangay_no = $request->barangay1;
                            $conperson_add->barangay = strtoupper($request->barangay_text1);
                        }
                        $conperson_add->save();
                        $conperson_add = $conperson_add->id;
                    }

                }

                if($request->contactperson_id !== null)
                {
                    $contactperson = User::find($request->contactperson_id);
                    $contactperson->role = 3;
                    $contactperson->name = strtoupper($request->contactperson);
                    $contactperson->contactnumber = $request->contactnumber;
                    $contactperson->relationshipthdeceased = $request->relationship;
                    $contactperson->address_id = $conperson_add;
                    $contactperson->update();
                    $contactperson = $request->contactperson_id;
                }

                $contactperson1 = null;
                $conperson_add1;
                
                if($request->addcontactperson == 1)
                {
                    if($request->sameaddress1 == 1) 
                    {
                        $conperson_add1 = $address;
                    }
                    else
                    {
                        $conperson_add1 = Address::where([
                            'region_no' => $request->region2,
                            'province_no' => $request->province2,
                            'city_no' => $request->city2,
                            'barangay_no' => $request->barangay2,
                        ])->first();
        
                        if($conperson_add1 !== null)
                        {
                            $conperson_add1 = $conperson_add1->id;
                        }
                        else
                        {
                            $conperson_add1 = new Address;
                            $conperson_add1->region_no = $request->region2;
                            $conperson_add1->region = strtoupper($request->region_text2);
                            $conperson_add1->province_no = $request->province2;
                            $conperson_add1->province =  strtoupper($request->province_text2);
                            $conperson_add1->city_no = $request->city2;
                            $conperson_add1->city = strtoupper($request->city_text2);
                            if($request->barangay2 !== null)
                            {
                                $conperson_add1->barangay_no = $request->barangay2;
                                $conperson_add1->barangay = strtoupper($request->barangay_text2);
                            }
                            $conperson_add1->save();
                            $conperson_add1 = $conperson_add1->id;
                        }
        
                    }

                    if($request->contactperson_id1 !== null)
                    {
                        $contactperson1 = User::find($request->contactperson_id1);
                        $contactperson1->role = 3;
                        $contactperson1->name = strtoupper($request->contactperson1);
                        $contactperson1->contactnumber = $request->contactnumber1;
                        $contactperson1->relationshipthdeceased = $request->relationship1;
                        $contactperson1->address_id = $conperson_add1;
                        $contactperson1->update();
                        $contactperson1 = $request->contactperson_id1;
                    }
                    else 
                    {
                        $exist_contactpeople = ContactPerson::where([
                            'deceased_id' => $request->deceased_id,
                            'user_id' => $request->contactperson_id1
                        ])->exists();
                        if(!$exist_contactpeople)
                        {
                            $contactperson1 = new User;
                            $contactperson1->role = 3;
                            $contactperson1->name = strtoupper($request->contactperson1);
                            $contactperson1->contactnumber = $request->contactnumber1;
                            $contactperson1->relationshipthdeceased = $request->relationship1;
                            $contactperson1->address_id = $conperson_add1;
                            $contactperson1->save();
                            $contactperson1 = $contactperson1->id;
                        }
                    }
                }

                $deceased = Deceased::find($request->cem_id);
                $deceased->service_id = 1;
                $deceased->address_id = $address;
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
                $deceased->update();

                $verify_contact = ContactPerson::where([
                    'deceased_id' => $request->cem_id,
                    'user_id' => $request->contactperson_id,
                ])->first();
                
                //Check if no changes.
                if($verify_contact === null)
                {
                    $dbcontactperson = new ContactPerson;
                    $dbcontactperson->user_id = $contactperson;
                    $dbcontactperson->deceased_id = $deceased->id;
                    $dbcontactperson->save();
                }

                $verify_contact1 = ContactPerson::where([
                    'deceased_id' => $request->cem_id,
                    'user_id' => $request->contactperson_id1,
                ])->first();

                if($verify_contact1 === null)
                {
                    if($contactperson1 !== null)
                    {
                        $dbcontactperson1 = new ContactPerson;
                        $dbcontactperson1->user_id = $contactperson1;
                        $dbcontactperson1->deceased_id = $deceased->id;
                        $dbcontactperson1->save();
                    }
                }
                $status = 1;    
                $message = "Deceased has been successfully updated.";
               
            }
            $json = [
                'status' => $status,
                'message' => $message,
            ];
            return response()->json($json);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    //THIS IS THE MAIN PROBLEM SOLVING OF THE SYSTEM.
    public function assign_block(Request $request, $deceased_id, $space_id)
    {
        $status = 0;
        $message = "";
        if($request->status == "assign")
        {
            $deceased = Deceased::find($deceased_id);
            $space_area = Block::find($space_id);
            if($request->payment > $space_area->block_cost)
            {
                $status = 2;
                $message = "Payment must below the block cost";
            }
            else
            {
                //Diri mag transact sa payment kung naa bay balance bayran ang client;
                $remainingBalance = 0;
                if($request->payment < $space_area->block_cost)
                {
                    $remainingBalance = $space_area->block_cost - $request->payment;
                }

                $deceased->remaining_balance = $remainingBalance;
                $deceased->update();

                $coffinplot = new CoffinPlot();
                $coffinplot->deceased_id = $deceased_id;
                $coffinplot->block_id = $space_id;
                $coffinplot->plot_number = 0001;
                $coffinplot->status = 1;
                $coffinplot->save();
        
                //Decrement blocks once coffinplot is occupied.
                $block = Block::find($space_id);
                $block->slot = $block->slot-1;
                $block->update();
                $status = 1;
                $message = 'The deceased has been plotted successfully.';
            }
        }
        if($request->status == "move")
        {
            if(Hash::check($request->password, Auth::user()->password))
            {
                $deceased = Deceased::find($deceased_id);
                $space_area = Block::find($space_id);
                if($request->payment > $space_area->block_cost)
                {
                    $status = 2;
                    $message = "Payment must below the block cost";
                }
                else
                {
                    //Diri mag transact sa payment kung naa bay balance bayran ang client;
                    $remainingBalance = 0;
                    if($request->payment < $space_area->block_cost)
                    {
                        $remainingBalance = $space_area->block_cost - $request->payment;
                    }

                    $deceased->remaining_balance = $remainingBalance;
                    $deceased->update();
                    //Return info 
                    $coffinplot = CoffinPlot::find($request->coffin_id);
                    $block_id = $coffinplot->block_id;
                    //Increment blocks once coffinplot is occupied.
                    $block = Block::find($block_id);
                    $block->slot = $block->slot+1;
                    $block->update();

                    //update new
                    $coffinplot = CoffinPlot::find($request->coffin_id);
                    $coffinplot->deceased_id = $deceased_id;
                    $coffinplot->block_id = $space_id;
                    $coffinplot->plot_number = 0001;
                    $coffinplot->status = 1;
                    $coffinplot->update();

                    //Decrement blocks once coffinplot is occupied.
                    $block = Block::find($space_id);
                    $block->slot = $block->slot-1;
                    $block->update();
                    $status = 1;
                    $message = 'The deceased has been plotted successfully.';
                }
            }
            else{
                $status = 0;
                $message = "Invalid Password!";
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    public function destroy(deceased $deceased)
    {
        //
    }

    public function designation(Request $request, $deceased_id, $service_id)
    {
        $status = 0;
        $msg = "";
        if($request->ajax())
        {
            if(Hash::check($request->password, Auth::user()->password))
            {
                if($request->status == "designation")
                {
                    $deceased = Deceased::find($deceased_id);
                    $deceased->service_id = $service_id;
                    $deceased->update();
                    $status = 1;
                    $msg = "Deceased has been successfully processed!";
                }
            }
            else
            {
                $status = 0;
                $msg = "Cannot proceed. Invalid Password";
            }
        }
        return response()->json([
            'status' => $status, 
            'message' => $msg
        ]);
    }
    
}
