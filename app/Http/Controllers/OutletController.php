<?php

namespace App\Http\Controllers;

use App\Imports\OutletsImport;
use Illuminate\Http\Request;
use App\Models\Outlet;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\Switch_;

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
            $outlet->created_by = Auth::User()->id;
            $outlet->updated_by = Auth::User()->id;
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
        ]);

        $id = $request->id;

        $return = [];
        try {
            $outlet = Outlet::find($id);
            $outlet->name = $request->name;
            $outlet->updated_by = Auth::User()->id;
            $outlet->save();

            $error = 'success';
        } catch (Exception $e) {
            $error = 'Error Message: ' .$e->getMessage();
        }

        $return['errors'] = $error;

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

        return $return;
    }

    public function uploadOutlets(Request $request)
    {
        $extension = $request->file('file')->getClientOriginalExtension();

        $ext = ['xlsx','xls'];

        if (!in_array($extension,$ext)){

            return redirect()->route('outlet.index')->with('message', 'Format file tidak sesuai !');
        }

        $tmp_path = $_FILES["file"]["tmp_name"];
        $filename = $_FILES['file']['name'];
        $target_file = storage_path('app'.DIRECTORY_SEPARATOR.$filename);

        // move file upload to storage
        move_uploaded_file($tmp_path, $target_file);
        
        try {
            Excel::import(new OutletsImport,$target_file);
            $return = 'Outlet Berhasil di Import !';
        } catch (\Throwable $th) {
            $return = 'Proses import gagal !';
        }

        File::delete($target_file);

        return redirect()->route('outlet.index')->with('message', $return);
    }
}
