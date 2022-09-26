<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Response;
use Redirect;
use App\Models\{Jabatan, Outlet, UserOutlet};

class DropdownController extends Controller
{
    public function index()
    {
        $outlets = Outlet::get(["name", "id"]);
        return view('posts.create', $outlets); 
    }
    public function fetchUserOutlet(Request $request)
    {   
        $useroutlet = UserOutlet::where("outlet_id", $request->outlet_id)
        ->where("status", 'AKTIF')
        ->get(["name", "id", "jabatan"]);
        foreach ($useroutlet as $key => $value) {
            $value->jabatan_name = Jabatan::find($value->jabatan)->name;
        }
        return response()->json($useroutlet);
    }
}
