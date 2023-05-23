<?php

namespace App\Http\Controllers;

use App\Models\services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('services');
    }
    public function get_allRecords()
    {
        $data = Services::all();
        echo json_encode($data);
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
        $validate = Validator::make($request->all(), [
            'service_name' => 'required|min:5|unique:services,service_name',
        ]);
        
        $status = 0;
        $messages = "";
        if($validate->fails())
        {
            $status = 2;
            $messages = $validate->messages();
        }
        else
        {
            $service = new Services;
            $service->service_name = ucwords($request->service_name);
            $service->save();

            $status = 1;
            $messages = "Service has been successfully added!";
        }
        echo json_encode(['status'=>$status, 'message'=>$messages]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = services::find($id);
        echo json_encode($service);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, services $services)
    {
        $validate = Validator::make($request->all(), [
            'service_name' => 'required|min:5|unique:services,service_name,'.$request->service_id.',id', 
        ]);
        
        $status = 0;
        $messages = "";
        if($validate->fails())
        {
            $status = 2;
            $messages = $validate->messages();
        }
        else
        {
            $service = Services::find($request->service_id);
            $service->service_name = ucwords($request->service_name);
            $service->update();

            $status = 1;
            $messages = "Service has been successfully updated!";
        }
        echo json_encode(['status'=>$status, 'message'=>$messages]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Services::find($id);
        $service->delete();
        echo json_encode([
            'status' => 1,
            'message' => 'Data has been successfully deleted'
        ]);
    }
}
