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
    public function fetchUsrOutlet(Request $request)
    {
        $useroutlet = UserOutlet::where("outlet_id", $request->outlet_id)->get(["name", "id"]);
        return response()->json($useroutlet);
    }
}
