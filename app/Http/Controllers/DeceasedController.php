<?php

namespace App\Http\Controllers;

use App\Models\deceased;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        //
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
