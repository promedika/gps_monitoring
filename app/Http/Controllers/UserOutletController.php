<?php

namespace App\Http\Controllers;

// use App\Models\UserOutlet;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Outlet;
use App\Models\UserOutlet;
use DB;

class UserOutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outlets = Outlet::get(["name", "id"]);
        $jabatans = Jabatan::get(["name", "id"]);

        $useroutlets = DB::table('user_outlets as uo')
        ->leftJoin('outlets as o', 'uo.outlet_id', '=', 'o.id')
        ->leftJoin('jabatans as j', 'uo.jabatan', '=', 'j.id')
        ->select('uo.id as user_outlets_id', 'uo.name as user_outlets_name', 'uo.status as user_outlets_status','o.id as outlets_id', 'o.name as outlets_name','j.id as jabatans_id', 'j.name as jabatans_name')
        ->get();
        return view('useroutlet.index', compact('useroutlets','outlets','jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $outlets = Outlet::get(["name", "id"]);
        $jabatans = Jabatan::get(["name","id"]);
        return view('useroutlet .create', ['outlets'=>$outlets], ['jabatans'=>$jabatans]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'outlet_id' => 'required',
            'jabatan'   => 'required',
            'status'    => 'required'
        ]);
        $useroutlet = new useroutlet();
        $useroutlet->name = $request->name;
        $useroutlet->outlet_id = $request->outlet_id;
        $useroutlet->jabatan = $request->jabatan;
        $useroutlet->status = $request->status;
        $useroutlet->created_by = Auth::User()->id;
        $useroutlet->updated_by = Auth::User()->id;
        $useroutlet->save();

        return redirect(route('useroutlet.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $useroutlets = UserOutlet::find($id);
        $outlets = Outlet::get(["name", "id"]);
        $jabatans = Jabatan::get(["name", "id"]);
        
        $return = [
            'useroutlets' => $useroutlets,
            'outlets' => $outlets,
            'jabatans' => $jabatans,
            'status' => 'required'
        ];

        return $return;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'outlet_id' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
        ]);
        $id = $request->id;
        $useroutlet = UserOutlet::find($id);
        $useroutlet->name = $request->name;
        $useroutlet->outlet_id = $request->outlet_id;
        $useroutlet->jabatan = $request->jabatan;
        $useroutlet->status = $request->status;
        $useroutlet->updated_by = Auth::User()->id;
        $useroutlet->save();
        return redirect(route('useroutlet.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $useroutlet = UserOutlet::find($id);
        $useroutlet->delete();
        return $useroutlet;

        return view('useroutlet.index', compact('useroutlets'));
    }
}   
