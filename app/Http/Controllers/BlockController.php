<?php

namespace App\Http\Controllers;

use App\Models\block;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('blockspage');
    }

    public function get_allBlocks()
    {
        $data = Block::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = 0;
        $message = "Cannot process your request.";

        if($request->ajax())
        {
            $validation = Validator::make($request->all(), [
                'block_number' => 'required|unique:blocks,block_number',
                'section_name' => 'required|string|unique:blocks,section_name',
                'block_cost' => 'required|numeric',
            ]);
    
            if($validation->fails())
            {
                $status = 2;
                $message = $validation->messages();
            }
            else
            {
                $block = new Block;
                $block->block_number = ucwords($request->block_number);
                $block->section_name = ucwords($request->section_name);
                $block->block_cost = $request->block_cost;
                $block->save();
    
                $status = 1;
                $message = "New space area has been successfully added.";
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Block::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, block $block)
    {
        $status = 0;
        $message = "Cannot process your request.";

        if($request->ajax())
        {
            $validation = Validator::make($request->all(), [
                'block_number' => 'required|unique:blocks,block_number,'.$request->block_id.',id',
                'section_name' => 'required|string|unique:blocks,section_name,'.$request->block_id.',id',
                'block_cost' => 'required|numeric',
            ]);
    
            if($validation->fails())
            {
                $status = 2;
                $message = $validation->messages();
            }
            else
            {
                $block = Block::find($request->block_id);
                $block->block_number = ucwords($request->block_number);
                $block->section_name = ucwords($request->section_name);
                $block->block_cost = $request->block_cost;
                $block->update();
    
                $status = 1;
                $message = "Space area has been successfully updated.";
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $block = Block::find($id);
        $block->delete();
        return response()->json([
            'message' => "Space area has been successfully removed.",
        ]);
    }
}
