<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Response;
use Redirect;
use App\Models\{Outlet, UserOutlet};

class DropdownController extends Controller
{
    public function index()
    {
        $outlets = Outlet::get(["name", "id"]);
        return view('posts.create', $outlets); 
    }
    public function fetchUserOutlet(Request $request)
    {
        $useroutlet = UserOutlet::where("outlet_id", $request->outlet_id)->get(["name", "id"]);
        // dd($useroutlet);
        return response()->json($useroutlet);
    }
}
