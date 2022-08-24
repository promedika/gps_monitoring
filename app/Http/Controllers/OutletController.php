<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outlets = Outlet::all();
        return view('outlet.index', compact('outlets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('outlet.create');
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
        ]);

        $return = [];
        try {
            $outlet = new outlet();
            $outlet->name = $request->name;
            $outlet->save();

            $error = 'success';
        } catch (Exception $e) {
            $error = 'Error Message: ' .$e->getMessage();
        }

        $return['errors'] = $error;

        // return redirect(route('outlet.index'));
        return $return;
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
        $outlet = Outlet::find($id);
        return response()->json(['data' => $outlet]);
        // return redirect(route('outlet.index'));
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
            'updated_by'=>'required',
        ]);

        $id = $request->id;

        $return = [];
        try {
            $outlet = Outlet::find($id);
            $outlet->name = $request->name;
            $outlet->save();

            $error = 'success';
        } catch (Exception $e) {
            $error = 'Error Message: ' .$e->getMessage();
        }

        $return['errors'] = $error;

        // return redirect(route('outlet.index'));
        return $return;
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

        $return = [];
        try {
            $outlet = Outlet::find($id);
            $outlet->delete();

            $error = 'success';
        } catch (Exception $e) {
            $error = 'Error Message: ' .$e->getMessage();
        }

        $return['errors'] = $error;

        // return view('outlet.index', compact('outlets'));
        return $return;
    }
}
