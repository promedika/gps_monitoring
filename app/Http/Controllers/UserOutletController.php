<?php

namespace App\Http\Controllers;

use App\Models\UserOutlet;
use Illuminate\Http\Request;
use App\Models\Outlet;
use Illuminate\Support\Facades\Auth;


class UserOutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $useroutlets = UserOutlet::all();
        $outlets = Outlet::get(["name", "id"]);
        return view('useroutlet.index', compact('useroutlets','outlets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $outlets = Outlet::get(["name", "id"]);
        return view('useroutlet .create', ['outlets'=>$outlets]);
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
        ]);
        $useroutlet = new useroutlet();
        $useroutlet->name = $request->name;
        $useroutlet->outlet_id = $request->outlet_id;
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
        
        $return = [
            'useroutlets' => $useroutlets,
            'outlets' => $outlets
        ];

        return $return;

        // dd($return);
        // return view('useroutlet.index', compact('useroutlets','outlets'));
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
        ]);
        $id = $request->id;
        $useroutlet = UserOutlet::find($id);
        $useroutlet->name = $request->name;
        $useroutlet->outlet_id = $request->outlet_id;
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
