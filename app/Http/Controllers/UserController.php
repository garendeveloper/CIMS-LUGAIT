<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Http\JsonResponse;
class UserController extends Controller
{
    public function index()
    {
        return view('users');
    }
    public function data()
    {
        $users = User::all();
        // return datatables()->of($users)->toJson();
        // return new JsonResponse(datatables()->of($users)->make(true));
       
        return datatables()->of($users)
                        ->addColumn('action', function ($row) {
                            $html = '<button align = "center" data-rowid="'.$row->id.'" id = "btn_edit" class="btn btn-xs btn-secondary"><i class = "fa fa-edit"></i></button> ';
                            $html .= '<button align= "center" data-rowid="'.$row->id.'" id = "btn_del"  class="btn btn-xs btn-danger"><i class = "fa fa-trash"></i></button>';
                            return $html;
                        })->toJson();

        
    }
}
