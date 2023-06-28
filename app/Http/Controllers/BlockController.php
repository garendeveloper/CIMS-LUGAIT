<?php

namespace App\Http\Controllers;

use App\Models\block;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CoffinPlot;
use File;
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
    public function get_classifiedBlocks($deceased_id)
    {
        $classifiedBlocks = [];
        $blocks = Block::all();
        $status = 0;
        foreach($blocks as $b)
        {
            $exist_coffinplot = CoffinPlot::where([
                'deceased_id' => $deceased_id,
                'block_id' => $b->id,
            ])->first();

            if($exist_coffinplot  !== null)
            {
                $status = 1;
                $classifiedBlocks[] = [
                    'id' => $b->id,
                    'image' => $b->image,
                    'section_name' => $b->section_name,
                    'slot' => $b->slot,
                    'block_cost' => $b->block_cost,
                    'status' => 1,
                    'coffin_id' => $exist_coffinplot->id,
                ];
            }
            else
            {
                $classifiedBlocks[] = [
                    'id' => $b->id,
                    'image' => $b->image,
                    'section_name' => $b->section_name,
                    'slot' => $b->slot,
                    'block_cost' => $b->block_cost,
                    'status' => 0, 
                    'coffin_id' => null,
                ];
            }
        }
        return response()->json([
            'cb'=>$classifiedBlocks,
            'status' => $status,
        ]);
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
                'slot' => 'required|numeric|min:0|not_in:0',
                'section_name' => 'required|string|unique:blocks,section_name',
                'block_cost' => 'required|numeric|min:0|not_in:0',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|unique:blocks,image'
            ]);
    
            if($validation->fails())
            {
                $status = 2;
                $message = $validation->messages();
            }
            else
            {
                $image = $request->file('image');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload_images'), $new_name);

                $block = new Block;
                $block->slot = strtoupper($request->slot);
                $block->section_name = strtoupper($request->section_name);
                $block->block_cost = $request->block_cost;
                $block->validity = $request->validity;
                $block->image = $new_name;
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
            if($request->type == "update_slot")
            {
                $validation = Validator::make($request->all(), [
                    '_slot' => 'required|numeric|min:1|not_in:0',
                    '_block_id' => 'required',
                ]);
        
                if($validation->fails())
                {
                    $status = 2;
                    $message = $validation->messages();
                }
                else
                {
                    $block = Block::find($request->_block_id);
                    $block->slot = $block->slot+$request->_slot;
                    $block->update();
        
                    $status = 1;
                    $message = "Section has been successfully expanded.";
                }
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function update_withImage(Request $request)
    {
        $status = 0;
        $message = "Cannot process your request.";
        if($request->ajax())
        {
            if($request->type == "update_block")
            {
                $validation = Validator::make($request->all(),[]);
                if($request->image != null)
                {
                    $validation = Validator::make($request->all(), [
                        'slot' => 'required|numeric|min:0|not_in:0',
                        'section_name' => 'required|string|unique:blocks,section_name,'.$request->block_id.',id',
                        'block_cost' => 'required|numeric',
                        'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|unique:blocks,image,'.$request->block_id.',id',
                    ]);
                }
                if($request->image == null)
                {
                    $validation = Validator::make($request->all(), [
                        'slot' => 'required|numeric|min:0|not_in:0',
                        'section_name' => 'required|string|unique:blocks,section_name,'.$request->block_id.',id',
                        'block_cost' => 'required|numeric',
                    ]);
                }
        
                if($validation->fails())
                {
                    $status = 2;
                    $message = $validation->messages();
                }
                else
                {
                    $block = Block::find($request->block_id);
                    if($request->image == null)
                    {
                        $block->slot = $request->slot;
                        $block->section_name = strtoupper($request->section_name);
                        $block->block_cost = $request->block_cost;
                        $block->validity = $request->validity;
                    }
                    else
                    {
                        //Delete Previous Image to reduce memory allocation
                        File::delete(public_path("upload_images/".$block->image));

                        $image = $request->file('image');
                        $new_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('upload_images'), $new_name);
                        
                        $block->slot = $request->slot;
                        $block->section_name = strtoupper($request->section_name);
                        $block->block_cost = $request->block_cost;
                        $block->validity = $request->validity;
                        $block->image = $new_name;
                       
                    }
                    $block->update();
                    $status = 1;
                    $message = "Space area has been successfully updated.";
                }
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
